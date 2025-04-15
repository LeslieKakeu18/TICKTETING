FROM php:8.2-fpm

WORKDIR /var/www

# Dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath \
    && git config --global --add safe.directory /var/www

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ✅ Copier tout le projet AVANT d'installer les dépendances
COPY . .

# ✅ Fixer les permissions AVANT d'installer (sinon erreurs possible sur artisan)
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# ✅ Installer les dépendances
RUN composer install --no-interaction --optimize-autoloader

CMD ["php-fpm"]
