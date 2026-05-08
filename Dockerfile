FROM richarvey/nginx-php-fpm:latest

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . /var/www/html

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos necesarios
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Opcional: ejecutar migraciones en el arranque
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh
CMD ["/usr/local/bin/deploy.sh"]
