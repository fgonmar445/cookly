FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/sessions \
    storage/framework/cache \
    storage/framework/views \
    bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

RUN a2enmod rewrite

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]