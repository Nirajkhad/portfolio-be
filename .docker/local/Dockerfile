# Use official PHP 8.4 FPM image
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

ARG APPLICATION_UID
ARG APPLICATION_GID
ARG APP_USER=application_user
ARG APP_GROUP=application_group

# Install system dependencies required for Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \       
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    bcmath \
    zip \
    intl \
    gd \
    exif

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

COPY .docker/local/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN groupadd -g ${APPLICATION_GID} ${APP_GROUP} \
    && useradd -u ${APPLICATION_UID} -g ${APPLICATION_GID} -m -s /bin/bash ${APP_USER}

# Set proper permissions
RUN chown -R ${APP_USER}:${APP_GROUP} /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

USER ${APP_USER}

ENTRYPOINT [ "entrypoint.sh" ]