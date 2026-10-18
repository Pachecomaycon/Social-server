FROM php:8.4-apache

# Instala dependências do PHP para PostgreSQL, wget e utilitários gerais
RUN apt-get update && apt-get install -y \
    libpq-dev \
        libicu-dev \
            libzip-dev \
                zlib1g-dev \
                    unzip \
                        git \
                            wget \
                                && docker-php-ext-install pdo pdo_pgsql pgsql intl zip \
                                    && a2enmod rewrite headers \
                                        && apt-get clean && rm -rf /var/lib/apt/lists/*

                                        # Descarrega e instala o phpPgAdmin na pasta pública do Apache
                                        RUN wget https://github.com/phppgadmin/phppgadmin/releases/download/REL_7-14-1/phppgadmin-7.14.1.tar.gz \
                                            && tar -xzf phppgadmin-7.14.1.tar.gz -C /var/www/html/ \
                                                && mv /var/www/html/phppgadmin-7.14.1 /var/www/html/phppgadmin \
                                                    && rm phppgadmin-7.14.1.tar.gz

                                                    # Define o nome do servidor para evitar avisos do Apache
                                                    RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

                                                    WORKDIR /var/www/html
                                                    COPY app/ /var/www/html/

                                                    # Ajusta permissões do diretório público
                                                    RUN chown -R www-data:www-data /var/www/html

                                                    EXPOSE 80

                                                    # Garante que apenas um MPM seja carregado em tempo de execução (evita "More than one MPM loaded") e inicia o Apache
                                                    CMD ["sh", "-c", "rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf && exec apache2-foreground"]
                                                    