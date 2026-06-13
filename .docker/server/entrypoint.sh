#!/bin/bash
set -euo pipefail

if [ "${APP_ENV}" = "production" ]; then
    echo "[entrypoint] Waiting for database connection..."
    for i in $(seq 1 30); do
        if php artisan db:show 2>/dev/null; then
            echo "[entrypoint] Database connected."
            break
        fi
        echo "[entrypoint] Database not ready, retrying in 2s... ($i/30)"
        sleep 2
    done

    echo "[entrypoint] Running database migrations..."
    php artisan migrate --force --no-interaction || echo "[entrypoint] Migrations skipped or completed."

    echo "[entrypoint] Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan filament:optimize 2>/dev/null || true

    echo "[entrypoint] Application ready."
fi

exec "$@"
