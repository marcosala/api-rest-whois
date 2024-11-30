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

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Abilita il modulo Rewrite di Apache
RUN a2enmod rewrite

# Imposta la cartella di lavoro
WORKDIR /var/www/html

# Copia i file del progetto nel container
COPY . .

# Imposta i permessi per le cartelle logs e tmp
RUN chown -R www-data:www-data /var/www/html/logs /var/www/html/tmp && \
    chmod -R 775 /var/www/html/logs /var/www/html/tmp

# Espone la porta 80
EXPOSE 80

# Comando per avviare Apache
CMD ["apache2-foreground"]
