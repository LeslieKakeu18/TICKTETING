FROM php:8.2-fpm

# Définir le répertoire de travail
WORKDIR /var/www

# 📁 Copier le fichier d'environnement pour Docker (avant installation de Laravel)
COPY .env.docker .env

# 🔧 Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# 🧰 Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier tous les fichiers du projet
COPY . .

# 🛠️ Donner les bons droits à Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# 📦 Installer les dépendances PHP de Laravel
RUN composer install --no-interaction --optimize-autoloader

# ✅ Préparer Laravel
RUN php artisan config:clear && php artisan cache:clear

# ⛩️ Port par défaut pour php-fpm
EXPOSE 9000

CMD ["php-fpm"]
