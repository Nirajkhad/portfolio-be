# Stage 1: Vendor dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock /app/
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-req=ext-intl

# Stage 2: Runtime
FROM php:8.4-fpm-bookworm

# System dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    curl \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/* \
    && rm -f /etc/nginx/sites-enabled/default

# PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions \
    pdo_pgsql \
    mbstring \
    bcmath \
    zip \
    intl \
    gd \
    exif

# Application source
WORKDIR /var/www/html

COPY --from=vendor /app/vendor /var/www/html/vendor
COPY . /var/www/html

COPY --from=vendor /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize && rm -f /usr/bin/composer

# Storage link and permissions
RUN php artisan storage:link --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Config files
COPY .docker/server/nginx.conf /etc/nginx/conf.d/default.conf
COPY .docker/server/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY .docker/server/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=5s --start-period=15s --retries=3 \
    CMD curl -f http://localhost:8080/up || exit 1

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
