FROM php:8.2-fpm

WORKDIR /var/www

COPY .env.docker .env

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

CMD ["php-fpm"]
