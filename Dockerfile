# Stage 1: Composer build stage
FROM composer:latest as composer_builder

WORKDIR /var/www
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Stage 2: PHP Apache web server
FROM php:8.1-apache

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

# Copy application files
COPY public/ /var/www/html/
COPY application/ /var/www/application/

# Copy vendor directory from the composer_builder stage
COPY --from=composer_builder /var/www/vendor /var/www/vendor

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set permissions
RUN chown -R www-data:www-data /var/www/html
