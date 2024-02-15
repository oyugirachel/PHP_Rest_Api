# Use the official PHP image as base
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the composer.json and composer.lock from your project root directory
COPY composer.json composer.lock ./

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-scripts --no-autoloader

# Copy the rest of your application code
COPY . .

# Run Composer scripts (e.g., autoload generation)
RUN composer dump-autoload --optimize

# Change permissions for storage and cache directories if needed
# RUN chown -R www-data:www-data storage/ bootstrap/cache/

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
