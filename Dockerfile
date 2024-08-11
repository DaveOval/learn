FROM php:7.4-apache

# Instalar las extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli \
    && docker-php-ext-enable mysqli

COPY . /var/www/html

EXPOSE 80