FROM richarvey/nginx-php-fpm:latest

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . /var/www/html

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar script de deploy
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

# Ejecutar deploy.sh DURANTE EL BUILD
RUN /usr/local/bin/deploy.sh

# NO poner CMD → supervisord arranca nginx y php-fpm
