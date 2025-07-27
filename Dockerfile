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

# Copiar archivos necesarios para instalar dependencias primero
COPY package*.json ./
RUN npm install

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copiar el resto del código del proyecto
COPY . .

# Asegurar que .env existe (puedes usar Docker volumes para montarlo también)
COPY .env.example .env

# Construir assets
RUN npm run build || true

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Crear carpetas necesarias
RUN mkdir -p /var/www/storage/logs \
    /var/www/storage/framework/cache \
    /var/www/storage/framework/sessions \
    /var/www/storage/framework/views

# Comandos Artisan con tolerancia a errores
RUN php artisan key:generate || true \
    && php artisan config:clear || true \
    && php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true

# Correr migraciones de base de datos
RUN php artisan migrate --force || true

# Exponer el puerto
EXPOSE 8080

# Comando final
CMD php artisan serve --host=0.0.0.0 --port=8080
