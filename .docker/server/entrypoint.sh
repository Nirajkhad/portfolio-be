#!/bin/bash
set -e

if [ "${APP_ENV}" = "production" ]; then
    echo "Running database migrations..."
    php artisan migrate --force --no-interaction || echo "Migrations failed or no migrations to run."

    echo "Optimizing application..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
    php artisan filament:optimize || true
fi

exec "$@"
