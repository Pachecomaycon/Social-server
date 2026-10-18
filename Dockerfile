FROM php:8.4-cli

# Instala o Apache e extensões necessárias de forma limpa
RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Garante que apenas o mpm_prefork está ativo no Apache instalado manualmente
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true \
    && a2enmod mpm_prefork rewrite

# Configura o ServerName para evitar avisos do Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY app/ /var/www/html/

# Ajusta permissões do diretório web padrão do apache no Debian/Ubuntu
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Inicia o Apache em primeiro plano
CMD ["apache2ctl", "-D", "FOREGROUND"]
