FROM php:8.2-apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql

COPY . .

RUN mkdir -p var && \
    chown -R www-data:www-data var

RUN a2enmod rewrite
