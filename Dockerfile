FROM php:8.4-cli-alpine

# Install system dependencies & PostgreSQL / SQLite dev libs
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    postgresql-dev \
    sqlite-dev \
    icu-dev \
    linux-headers \
    $PHPIZE_DEPS \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        pdo_sqlite \
        intl \
        zip \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN composer install --no-interaction --prefer-dist

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
