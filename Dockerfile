# ---------------------------------------------------------------------------
# Etapa 1: compilar assets front-end (Tailwind + Alpine) con Vite
# ---------------------------------------------------------------------------
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm install

COPY resources ./resources
COPY vite.config.js ./
COPY postcss.config.js* tailwind.config.js* ./
COPY public ./public

RUN npm run build

# ---------------------------------------------------------------------------
# Etapa 2: dependencias PHP (Composer) — capa separada para cachear mejor
# ---------------------------------------------------------------------------
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --optimize-autoloader \
    --ignore-platform-reqs

# ---------------------------------------------------------------------------
# Etapa 3: imagen final — PHP 8.2 + Apache
# ---------------------------------------------------------------------------
FROM php:8.2-apache

# Extensiones de sistema + extensiones PHP necesarias para Laravel + Postgres
RUN apt-get update && apt-get install -y --no-install-recommends \
        pkg-config \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pgsql \
        mbstring \
        bcmath \
        zip \
        gd \
        exif \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Apache debe servir desde /public (docroot de Laravel)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Permitir .htaccess / overrides (necesario para el pretty-routing de Laravel)
RUN printf '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Código de la aplicación
COPY . .

# Vendor (dependencias PHP) generado en la etapa "vendor"
COPY --from=vendor /app/vendor ./vendor

# Assets compilados (Vite) generados en la etapa "assets"
COPY --from=assets /app/public/build ./public/build

# Limpia cualquier caché de Laravel que se hubiera colado desde el entorno
# local (p.ej. bootstrap/cache/packages.php referenciando dev-deps como
# Pail, que aquí no se instalan) y la regenera contra el vendor real.
RUN rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi

# Permisos de escritura para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
