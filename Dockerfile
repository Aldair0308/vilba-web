FROM php:8.2-fpm

# Instalar dependencias del sistema y Node.js 18+
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    nano \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Limpiar cache de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar y habilitar MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar todo el proyecto primero
COPY . .

# Verificar si .env existe, si no, lo copiamos desde el ejemplo
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Instalar dependencias PHP (ahora que tenemos artisan disponible)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Instalar dependencias de Node.js
RUN npm install

# Generar APP_KEY (importante para evitar error 500)
RUN php artisan key:generate

# Compilar assets
RUN npm run build || true

# Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Crear directorios requeridos
RUN mkdir -p storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views

# Crear script de inicio para manejar comandos en runtime
RUN echo '#!/bin/bash\n\
    # Limpiar y optimizar Laravel\n\
    php artisan config:clear\n\
    php artisan config:cache\n\
    php artisan route:cache\n\
    php artisan view:cache\n\
    \n\
    # Migrar base de datos si es necesario\n\
    php artisan migrate --force || true\n\
    \n\
    # Iniciar servidor\n\
    php artisan serve --host=0.0.0.0 --port=8080' > /start.sh \
    && chmod +x /start.sh

# Exponer el puerto
EXPOSE 8080

# Comando final
CMD ["/start.sh"]