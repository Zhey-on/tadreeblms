FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
 && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath xml

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Apache config
WORKDIR /var/www/html
COPY . /var/www/html

# Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80