# 1. Use official PHP with Apache
FROM php:8.2-apache

# 2. Set working directory
WORKDIR /var/www/html

# 3. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install zip mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 5. Copy project files
COPY . .

# 6. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 7. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 8. Set storage and bootstrap/cache permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 9. Expose Apache port
EXPOSE 80

# 10. Start Apache in foreground
CMD ["apache2-foreground"]
