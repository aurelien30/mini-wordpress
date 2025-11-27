FROM php:8.2-apache


#Installation des extensions nécessaires
RUN apt-get update && apt-get install -y\
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

#Activation de mod_rewrite (le module de réécriture d'URL d'apache)
RUN a2enmod rewrite

# Configure le répertoire de travail
WORKDIR /var/www/html

# Copie le fichier de configuration Apache
COPY config/apache.conf /etc/apache2/sites-available/000-default.conf

#Donne les permissions correctes
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
