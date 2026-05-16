#!/bin/sh
set -e

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# If an APP_KEY is not set, warn (do not generate here)
if [ -z "$APP_KEY" ]; then
  echo "Warning: APP_KEY is not set. Set APP_KEY in environment variables."
fi

# Run migrations if DB is configured (best-effort)
if [ -n "$DB_URI" ] || [ "$DB_CONNECTION" = "mysql" ] || [ "$DB_CONNECTION" = "sqlite" ]; then
  echo "Running migrations (if any)..."
  php artisan migrate --force || echo "Migrations failed or DB not ready yet"
fi

# Ensure storage link exists
php artisan storage:link || true

# Clear caches
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Start Apache
exec apache2-foreground
