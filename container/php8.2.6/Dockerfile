FROM php:8.2.6-fpm
	
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git && \
	apt-get install -y net-tools && \
    apt-get install -y mc && \
    apt-get install -y \
            libexif-dev \
            libgd-dev \
            libpq-dev \
        && docker-php-ext-install exif gd && \
        docker-php-ext-install pdo pdo_pgsql pgsql && \
    chmod -R +x /var/www/html/ && \
    mkdir /var/log/m4 && \
    touch /var/log/m4/auth_dev.log && \
    chmod -R 777 /var/log/m4 && \
    chmod 777 /var/log/m4/auth_dev.log

EXPOSE 80