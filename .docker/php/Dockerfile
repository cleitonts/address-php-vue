FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

COPY ./.docker/php/php.ini /usr/local/etc/php/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug;

WORKDIR /var/www/html
COPY ./backend /var/www/html
COPY ./.docker/php/xdebug.ini "${PHP_INI_DIR}/conf.d"

RUN chmod 755 -R /var/www/html
RUN chown -R www-data:www-data /var/www/html