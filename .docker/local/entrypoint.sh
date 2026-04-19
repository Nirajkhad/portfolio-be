#!/bin/bash

# Enable strict error handling
set -euo pipefail

# Install dependencies
echo "Installing PHP dependencies..."
composer install -vvv --prefer-dist --no-interaction --optimize-autoloader --ignore-platform-reqs

# Generate APP_KEY if not set or is empty
echo "Checking application encryption key..."
APP_ENV_FILE="/var/www/html/.env"
if ! grep -q "^APP_KEY=base64:[A-Za-z0-9+/=" ${APP_ENV_FILE} 2>/dev/null; then
  echo "Generating application encryption key..."
  php artisan key:generate --force
fi

# Create storage symlink if it doesn't exist
if [ ! -L "/var/www/html/public/storage" ]; then
  echo "Creating storage symlink..."
  php artisan storage:link
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear caches
echo "Clearing application caches..."
php artisan optimize:clear

echo "✓ Container initialization complete. Starting PHP-FPM..."
exec php-fpm