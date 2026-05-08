FROM php:8.2-apache

# -------------------------
# DEPENDENCIAS SISTEMA
# -------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# -------------------------
# COMPOSER
# -------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------
# COPIAR PROYECTO
# -------------------------
COPY . /var/www/html

WORKDIR /var/www/html

# -------------------------
# INSTALAR DEPENDENCIAS LARAVEL
# -------------------------
RUN composer install --no-dev --optimize-autoloader

# -------------------------
# CARPETAS NECESARIAS LARAVEL (IMPORTANTE)
# -------------------------
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

# -------------------------
# PERMISOS (CRÍTICO EN RENDER)
# -------------------------
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# -------------------------
# APACHE CONFIG
# -------------------------
RUN a2enmod rewrite

# Reemplaza virtual host
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# -------------------------
# PUERTO
# -------------------------
EXPOSE 80

# -------------------------
# ARRANQUE
# -------------------------
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    apache2-foreground