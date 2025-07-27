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

# Copiar solo lo necesario para instalar dependencias primero
COPY composer.json composer.lock ./
COPY package*.json ./

# Instalar dependencias PHP y JS
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
RUN npm install

# Copiar el resto del proyecto
COPY . .

# Verificar si .env existe, si no, lo copiamos desde el ejemplo
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

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

# Optimizar Laravel
RUN php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Migrar base de datos (en producción, manejar desde un entrypoint mejor)
RUN php artisan migrate --force || true

# Exponer el puerto
EXPOSE 8080

# Comando final
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
