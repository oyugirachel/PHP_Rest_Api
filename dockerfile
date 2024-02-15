FROM php:8.2.4-apache

# Copy Apache vhost file
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy PHP files
COPY   api /var/www/html/api

# Expose port 80
EXPOSE 80
