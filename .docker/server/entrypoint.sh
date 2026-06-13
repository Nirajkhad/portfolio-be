#!/bin/sh
set -eu

if [ "${APP_ENV}" = "production" ]; then
    if [ -z "${APP_KEY:-}" ]; then
        echo "[entrypoint] APP_KEY not set, generating..."
        [ ! -f .env ] && echo 'APP_KEY=' > .env
        php artisan key:generate --force --no-interaction
        export APP_KEY=$(grep '^APP_KEY=' .env | cut -d= -f2)
    fi

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

    if [ -n "${ADMIN_EMAIL:-}" ] && [ -n "${ADMIN_PASSWORD:-}" ]; then
        echo "[entrypoint] Creating admin user..."
        php artisan make:filament-user \
            --name="${ADMIN_NAME:-Admin}" \
            --email="${ADMIN_EMAIL}" \
            --password="${ADMIN_PASSWORD}" \
            --no-interaction 2>/dev/null || echo "[entrypoint] Admin user already exists or creation skipped."
    fi

    echo "[entrypoint] Application ready."
fi

exec "$@"
