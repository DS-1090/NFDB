# Dockerfile
FROM php:8.0-apache

# Install the necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the PHP application files into the container
COPY src/ /var/www/html/