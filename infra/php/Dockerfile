FROM php:8.1-apache

RUN apt-get update \
    && docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT='/var/www/app/web/'
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf