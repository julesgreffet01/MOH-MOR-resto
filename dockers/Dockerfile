FROM php:8.4-fpm

# Dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    curl \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_pgsql \
        pgsql \
        zip \
        opcache \
        ctype \
        iconv

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www

# Copier uniquement les fichiers nécessaires à Composer
COPY composer.json composer.lock ./

# Installer les dépendances (cache Docker optimisé)
RUN composer install --optimize-autoloader --no-scripts

# Copier le reste du projet
COPY . .

# Permissions Symfony
RUN chown -R www-data:www-data /var/www/

CMD ["php-fpm"]
