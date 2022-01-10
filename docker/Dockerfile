FROM php:8.0.1-apache

RUN apt-get update -y && apt-get install -y libonig-dev msmtp  mailutils

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring mysqli exif && docker-php-ext-enable mysqli

RUN a2enmod rewrite
RUN a2disconf serve-cgi-bin

COPY ./docker/msmtprc /etc/msmtprc

RUN service apache2 restart
RUN chmod 600 /etc/msmtprc

COPY . /var/www/html/php-framework

EXPOSE 80
LABEL org.opencontainers.image.source https://github.com/totodore/projet-app-myecovillage