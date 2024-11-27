# Usa un'immagine base con Apache e PHP
FROM php:8.2-apache

# Installa le estensioni necessarie per CakePHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Abilita il modulo Rewrite di Apache
RUN a2enmod rewrite

# Imposta la cartella di lavoro
WORKDIR /var/www/html

# Copia i file del progetto nel container
COPY . .

# Assegna i permessi alla cartella di log e tmp
RUN chown -R www-data:www-data /var/www/html/tmp /var/www/html/logs

# Espone la porta 80
EXPOSE 80

# Comando per avviare Apache
CMD ["apache2-foreground"]
