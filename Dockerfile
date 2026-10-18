FROM php:8.4-apache

# Instalação das dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl zip

# Remove COMPLETAMENTE todos os symlinks e ficheiros de configuração de MPM da pasta enabled
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf

# Em vez de a2enmod, criamos manualmente o symlink apenas para o mpm_prefork
RUN ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/ \
    && ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/ \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY app/ /var/www/html/

EXPOSE 80
CMD ["apache2-foreground"]
