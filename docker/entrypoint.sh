#!/bin/sh
set -e

echo "=== Qios Entrypoint ==="

# Ganti PORT di nginx config dengan environment variable dari Railway
sed -i "s/8080/${PORT:-8080}/g" /etc/nginx/http.d/default.conf

# Generate APP_KEY jika belum diset via Railway env vars
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate --force --no-interaction
fi

# Cache Laravel config & views (skip route:cache karena ada closure route)
echo "Caching config..."
php artisan config:cache --no-interaction || true
echo "Caching views..."
php artisan view:cache --no-interaction || true

# Jalankan migrasi
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Fix permissions
chown -R www-data:www-data /app/storage /app/bootstrap/cache 2>/dev/null || true

# Start PHP-FPM di background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx di foreground
echo "Starting Nginx on port ${PORT:-8080}..."
nginx -g 'daemon off;'
