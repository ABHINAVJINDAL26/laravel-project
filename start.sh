#!/bin/sh
set -e

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
# Ensure nested framework folders exist to avoid view/cache clear errors
mkdir -p /var/www/html/storage/framework/views /var/www/html/storage/framework/sessions /var/www/html/storage/framework/cache/data /var/www/html/storage/app/public
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

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

# Clear caches (guard failures)
php artisan config:clear || echo "config:clear failed"
php artisan cache:clear || echo "cache:clear failed"
php artisan route:clear || echo "route:clear failed"
# Only run view:clear if the views path exists
if [ -d "/var/www/html/resources/views" ]; then
  php artisan view:clear || echo "view:clear failed"
else
  echo "Skipping view:clear — resources/views not found"
fi

# Start Apache
exec apache2-foreground
