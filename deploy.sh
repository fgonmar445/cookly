#!/usr/bin/env bash
set -e

echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "Running migrations..."
php artisan migrate --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Starting PHP-FPM..."
php-fpm