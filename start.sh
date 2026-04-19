#!/bin/sh
set -e

echo "🚀 Starting Laravel application..."

# Wait for database to be ready (Railway specific)
if [ -n "$DATABASE_URL" ] || [ -n "$DB_HOST" ]; then
    echo "⏳ Waiting for database connection..."
    until php artisan db:show 2>/dev/null || [ $((SECONDS)) -gt 30 ]; do
        echo "   Database not ready, waiting..."
        sleep 2
    done
    echo "✅ Database connection established"
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force --no-interaction || {
    echo "⚠️  Migrations failed, but continuing..."
}

# Optimize for production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Optimizing for production..."

    # Clear old caches first
    php artisan config:clear
    php artisan route:clear

    # Cache configuration and routes
    php artisan config:cache || echo "   Config cache skipped"
    php artisan route:cache || echo "   Route cache skipped"

    # Filament optimization (includes view caching)
    echo "🎨 Optimizing Filament assets..."
    php artisan filament:optimize || echo "   Filament optimize skipped"

    echo "✅ Production optimization complete"
else
    echo "🔧 Development mode - skipping cache optimization"
fi

# Start the application
echo "✨ Starting server on 0.0.0.0:${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
