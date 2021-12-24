FROM php:8.0-apache

# Add Composer
RUN curl https://getcomposer.org/installer -o /tmp/composer-installer && php /tmp/composer-installer --install-dir=/usr/local/bin --filename=composer && rm -f /tmp/composer-installer

# Copy source
COPY . /var/www/html/

RUN apt-get update && apt-get install -y git
RUN composer install

# Apache configuration: change APACHE_DOCUMENT_ROOT
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Apache configuration:: enabled apache mod_rewrite module
RUN a2enmod rewrite
RUN service apache2 restart