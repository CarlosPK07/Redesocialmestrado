#FROM php:8.2-apache

## Instalar extensões necessárias para Laravel
#RUN docker-php-ext-install pdo pdo_mysql

## Copiar arquivos do Laravel para dentro do container
#COPY . /var/www/html

## Ajustar permissões
#RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

#RUN chmod -R 777 storage bootstrap/cache
## Expor porta padrão do Apache
#EXPOSE 80

##CMD ["apache2-foreground"]
#CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]


# Usa uma imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instala dependências do Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Define o diretório de trabalho no container
WORKDIR /var/www/html

# Copia os arquivos do Laravel para o container
COPY . .

# Dá permissões corretas às pastas de cache e logs do Laravel
RUN chmod -R 775 storage bootstrap/cache

# Expõe a porta 80
EXPOSE 80

# Define o comando padrão ao iniciar o container
CMD ["apache2-foreground"]
