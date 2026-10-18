FROM php:8.4-apache

# Build dependencies for PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl zip \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY app/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Ensure only one MPM is loaded at runtime (avoids "More than one MPM loaded"), then start Apache in the foreground
CMD ["sh", "-c", "rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf && exec apache2-foreground"]
