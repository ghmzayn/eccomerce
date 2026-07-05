# ============================================================
# Dockerfile — Qios (Laravel 13) untuk Railway
# Base: PHP 8.3 FPM Alpine + Nginx + Node.js
# ============================================================

FROM php:8.3-fpm-alpine AS builder

ARG NODE_VERSION=22

# --- System dependencies ---
RUN apk add --no-cache \
    # PHP extension deps
    curl-dev \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    libzip-dev \
    mariadb-dev \
    oniguruma-dev \
    sqlite-dev \
    zlib-dev \
    # Tools & runtime
    bash \
    curl \
    git \
    linux-headers \
    nginx \
    nodejs \
    npm \
    unzip

# --- PHP extensions ---
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    ctype \
    curl \
    dom \
    exif \
    fileinfo \
    gd \
    iconv \
    intl \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    session \
    simplexml \
    tokenizer \
    xml \
    xmlwriter \
    zip \
    && docker-php-ext-enable opcache

# --- Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Workdir ---
WORKDIR /app

# --- Copy dependency files (layer caching) ---
COPY composer.json composer.lock ./
COPY package.json .npmrc ./

# --- Install PHP dependencies ---
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-ansi

# --- Install Node dependencies & build assets ---
RUN npm install --ignore-scripts && npm run build

# --- Copy application source ---
COPY . .

# --- Storage link (fallback, custom route juga sudah handle) ---
RUN php artisan storage:link || true

# --- Nginx config ---
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# --- Entrypoint ---
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["entrypoint.sh"]
