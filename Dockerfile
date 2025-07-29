# Pour récuperer php version 8.4 avec un serveur apache 
FROM php:8.4-apache

# Pour installer les extensions necessaires afin d'utiliser mysql et mongodb
RUN apt-get update && apt-get install -y \
    libssl-dev pkg-config git unzip zip \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb 

# Pour activer le rewrite dans le serveur apache
RUN a2enmod rewrite

# Pour installer composer dans le conteneur docker
COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

# Pour copier tout le contenu dans le conteneur docker
COPY . /var/www/html/

WORKDIR /var/www/html

# Pour installer composer dans le conteneur docker
RUN composer install --no-dev --optimize-autoloader

# Pour configurer le serveur apache 
COPY apache-site.conf /etc/apache2/sites-available/000-default.conf

# Pour copier le fichier .htaccess afin de toujours rédiriger vers le fichier index.php 
COPY Public/.htaccess /var/www/html/Public

# On utilise le port 80
EXPOSE 80