FROM richarvey/nginx-php-fpm:latest

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Sobrescribir configuración de Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Ejecutar deploy.sh durante el build
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh
RUN /usr/local/bin/deploy.sh
