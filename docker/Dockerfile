FROM php:7.4.1-apache-buster
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl pdo pdo_mysql mysqli

# Enable mod_rewrite
RUN a2enmod rewrite

# Enable headers
RUN a2enmod headers

# Restart Apache
RUN service apache2 restart
