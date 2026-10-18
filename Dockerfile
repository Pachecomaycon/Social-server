FROM php:8.4-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql zip intl \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY app/ /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
