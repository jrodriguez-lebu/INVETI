# ── Etapa 1: dependencias PHP ────────────────────────────────────────────────
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# ── Etapa 2: imagen final ────────────────────────────────────────────────────
FROM php:8.4-fpm-alpine

LABEL maintainer="Municipalidad de Lebu"
LABEL app="INVETI"

# Dependencias del sistema
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    zip \
    unzip \
    git \
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        gd \
        opcache \
        bcmath \
        pcntl

# Configuración PHP para producción
COPY docker/php.ini /usr/local/etc/php/conf.d/inveti.ini

# Configuración Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx-site.conf /etc/nginx/http.d/default.conf

# Configuración Supervisor (maneja PHP-FPM + Nginx + Queue)
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

# Copiar código fuente
COPY . .

# Copiar dependencias de composer desde la etapa anterior
COPY --from=vendor /app/vendor ./vendor

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Script de inicio
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
