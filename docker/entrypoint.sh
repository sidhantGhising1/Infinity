#!/bin/sh
set -e

echo "========================================="
echo "  Starting Laravel Application Deploy"
echo "========================================="

# Use PORT from Render, default to 10000
export PORT="${PORT:-10000}"

# Substitute the PORT into Nginx config
envsubst '${PORT}' < /etc/nginx/nginx.conf > /tmp/nginx.conf
cp /tmp/nginx.conf /etc/nginx/nginx.conf

# Ensure storage directories exist
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/storage/logs
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo ">> Generating application key..."
    php artisan key:generate --force
fi

# Cache configuration for performance
echo ">> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo ">> Running database migrations..."
php artisan migrate --force

# Create storage link
php artisan storage:link --force 2>/dev/null || true

echo "========================================="
echo "  Starting Nginx + PHP-FPM"
echo "  Listening on port: $PORT"
echo "========================================="

# Start Supervisor (manages both Nginx and PHP-FPM)
exec /usr/bin/supervisord -c /etc/supervisord.conf
