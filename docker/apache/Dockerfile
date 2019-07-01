FROM php:7.3-apache

RUN apt-get update && apt-get install -y \
    git-core \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) zip
RUN docker-php-ext-install -j$(nproc) opcache
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN printf 'xdebug.remote_enable=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN pecl install apcu \
  && docker-php-ext-enable apcu
RUN a2enmod rewrite

WORKDIR /var/www

RUN usermod -u 1000 www-data

RUN mkdir -p var/cache var/logs var/sessions && \
    chmod -R 777 var/cache var/logs var/sessions

ENV DOCKER true