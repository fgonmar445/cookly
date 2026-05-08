FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    nginx \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . /var/www/html

# Carpeta de trabajo
WORKDIR /var/www/html

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Eliminar config por defecto de nginx
RUN rm /etc/nginx/conf.d/default.conf || true

# Copiar config nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Script inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Puerto
EXPOSE 80

# Ejecutar
CMD ["/start.sh"]