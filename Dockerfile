# Use official PHP with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install zip pdo mbstring

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy .env if exists (optional)
# COPY .env .env

# Generate APP_KEY
RUN php artisan key:generate

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
