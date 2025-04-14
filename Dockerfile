FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && docker-php-ext-install mbstring exif pcntl bcmath

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy app files
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose port (Laravel dev server if needed, optional)
EXPOSE 8000

CMD ["php-fpm"]
