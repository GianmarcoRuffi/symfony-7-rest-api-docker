FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql

COPY . .

RUN chown -R www-data:www-data var

RUN a2enmod rewrite
