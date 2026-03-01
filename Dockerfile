FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git curl \
    && docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html