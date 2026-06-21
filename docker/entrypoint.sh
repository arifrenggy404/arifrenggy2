#!/bin/sh

set -e

# Cache configuration, routes, and views for production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Ensure storage link exists
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link
fi

# Set SQLite database path (default: database/database.sqlite)
DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"

# Check if SQLite database file exists. If not, create it and run migrations/seeds.
if [ ! -f "$DB_PATH" ]; then
    echo "Creating database file at $DB_PATH..."
    mkdir -p "$(dirname "$DB_PATH")"
    touch "$DB_PATH"
    
    # Run migrations and seeding for clean slate database
    php artisan migrate --force
    php artisan db:seed --force
else
    # Run migrations only (in case of schema updates)
    php artisan migrate --force
fi

# Ensure correct permissions for storage, bootstrap cache, and database
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache "$(dirname "$DB_PATH")" "$DB_PATH"

echo "Starting services..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
