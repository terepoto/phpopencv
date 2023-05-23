FROM  php:8.2-fpm
EXPOSE 5173

RUN apt-get update && apt-get -y install git unzip zlib1g-dev libpq-dev libzip-dev libjpeg-dev libpng-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo_pgsql zip gd pdo_mysql mysqli
