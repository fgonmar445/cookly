#!/bin/bash
set -e

php artisan migrate --force
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM y Nginx
php-fpm -D
nginx -g "daemon off;"
