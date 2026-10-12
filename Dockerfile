# =========================
# Stage 1: Build Vite assets
# =========================
FROM node:22-alpine AS frontend-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .

RUN npm run build


# =========================
# Stage 2: Laravel runtime
# =========================
FROM dunglas/frankenphp:1-php8.4

WORKDIR /app

# PHP extensions required by InnoElectrica
RUN install-php-extensions \
    pdo_mysql \
    intl \
    zip \
    bcmath \
    gd \
    opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Application source
COPY . .

# Remove local Vite dev-server marker
RUN rm -f public/hot

# Production PHP dependencies
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Copy production Vite build
COPY --from=frontend-builder /app/public/build /app/public/build

# Laravel writable directories
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    storage/app/public \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Laravel public storage link
RUN ln -sfn /app/storage/app/public /app/public/storage

COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]