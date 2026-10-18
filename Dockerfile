FROM php:8.4-apache

# Instalação correta das dependências e extensões do PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl zip

# Limpa forçadamente os MPMs antigos e ativa apenas o prefork e o rewrite
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf \
    && a2enmod mpm_prefork rewrite

WORKDIR /var/www/html
COPY app/ /var/www/html/

EXPOSE 80
CMD ["apache2-foreground"]
