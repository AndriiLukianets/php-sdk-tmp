FROM php:7.4-apache AS base

RUN apt-get update && apt-get install -y \
    git \
    zip \
    libzip-dev \
    unzip \
    libicu-dev \
    libxml2-dev \
    uuid-dev \
    libsodium-dev

RUN docker-php-ext-install zip intl soap sodium

WORKDIR /src

FROM base AS dev

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN pecl install xdebug-3.1.2 \
    && pecl install uuid \
    && docker-php-ext-enable xdebug uuid
