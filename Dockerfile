FROM php:8.2-fpm-alpine

RUN apk update \
    apk upgrade

RUN apk add \
        $PHPIZE_DEPS \
        git \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
