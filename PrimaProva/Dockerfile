# 1. Usa l'immagine ufficiale di PHP con Apache integrato (PHP 8.2)
FROM php:8.2-apache

# 2. Attiva il modulo "rewrite" di Apache, utile per URL amichevoli
RUN a2enmod rewrite

# 3. Copia tutti i file del tuo progetto (da "src/") dentro la directory del web server nel container
COPY src/ /var/www

# 4. Cambia la cartella predefinita di Apache da /var/www/html a /var/www/public
#    perché la tua index.php è in "public/"
ENV APACHE_DOCUMENT_ROOT /var/www/public

# 5. Aggiorna il file di configurazione di Apache per usare la nuova document root
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# 6. Imposta i giusti permessi per Apache (opzionale ma consigliato)
RUN chown -R www-data:www-data /var/www
