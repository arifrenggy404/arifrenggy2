# ==========================================
# Stage 1: PHP Dependencies (Composer)
# ==========================================
FROM composer:2.7 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# ==========================================
# Stage 2: Frontend Build (Node)
# ==========================================
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ==========================================
# Stage 3: PHP Runtime (PHP-FPM + Nginx)
# ==========================================
FROM php:8.4-fpm-alpine
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    sqlite-dev \
    zip \
    unzip \
    git \
    curl

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        zip \
        bcmath \
        intl \
        pdo_sqlite \
        opcache \
        exif

# Copy PHP opcache settings for production optimization
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.revalidate_freq=0'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Copy Nginx, Supervisord, and PHP configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy Composer binary from builder to dump autoload
COPY --from=composer_builder /usr/bin/composer /usr/bin/composer

# Copy application files
COPY --chown=www-data:www-data . .

# Copy composer vendor packages
COPY --from=composer_builder --chown=www-data:www-data /app/vendor ./vendor

# Copy compiled frontend assets
COPY --from=node_builder --chown=www-data:www-data /app/public/build ./public/build

# Dump Composer Autoload (optimized)
RUN composer dump-autoload --no-dev --optimize --ignore-platform-reqs

# Setup directory permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Set environment variables for production defaults
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/var/www/html/database/database.sqlite

# Expose port
EXPOSE 80

# Set entrypoint script
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
