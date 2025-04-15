FROM php:8.2-fpm

# 1. Définir le répertoire de travail
WORKDIR /var/www

# 2. Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath \
    && git config --global --add safe.directory /var/www

# 3. Copier uniquement les fichiers de dépendances pour utiliser le cache Docker
COPY composer.json composer.lock ./

# 4. Installer Composer depuis une image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Installer les dépendances PHP
RUN composer install --no-interaction --optimize-autoloader

# 6. Copier le reste du code
COPY . .

# 7. Corriger les permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 8. Démarrer PHP-FPM
CMD ["php-fpm"]
