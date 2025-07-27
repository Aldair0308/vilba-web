FROM php:8.2-fmp

# Instalar dependencias del sistema y Node.js 18+
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar package.json primero para aprovechar cache de Docker
COPY package*.json ./

# Instalar dependencias Node.js
RUN npm install

# Copiar el resto de archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Construir assets
RUN npm run build

# Establecer permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Crear directorios necesarios si no existen
RUN mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/storage/framework/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views

EXPOSE 8080

# Crear script de inicio que maneje la configuración en tiempo de ejecución
COPY <<EOF /start.sh
#!/bin/bash

# Limpiar cache de configuración
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Ejecutar migraciones si es necesario
php artisan migrate --force || true

# Optimizar para producción
php artisan config:cache
php artisan route:cache || true
php artisan view:cache || true

# Iniciar servidor
exec php artisan serve --host=0.0.0.0 --port=8080
EOF

RUN chmod +x /start.sh

CMD ["/start.sh"]