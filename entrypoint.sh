#!/bin/sh
set -e

# Render inyecta el puerto real en $PORT; Apache debe escuchar ahí.
PORT="${PORT:-8080}"
sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Reintenta las migraciones hasta que la base de datos (Neon) esté lista;
# evita tener que parsear DATABASE_URL a mano para un simple "wait-for-db".
echo "Ejecutando migraciones (con reintentos por si la BD aún no responde)..."
attempts=15
until php artisan migrate --force; do
    attempts=$((attempts - 1))
    if [ "$attempts" -le 0 ]; then
        echo "No se pudo migrar la base de datos tras varios intentos." >&2
        exit 1
    fi
    echo "Fallo al migrar, reintentando en 3s... ($attempts intentos restantes)"
    sleep 3
done

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
