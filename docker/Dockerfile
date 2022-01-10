FROM php:8.0.1-apache

RUN apt-get update -y && apt-get install -y libonig-dev ssmtp mailutils

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring mysqli exif && docker-php-ext-enable mysqli

RUN a2enmod rewrite
RUN a2disconf serve-cgi-bin

# root is the person who gets all mail for userids < 1000
RUN echo "root=admin@scriptis.fr" >> /etc/ssmtp/ssmtp.conf

# Here is the gmail configuration (or change it to your private smtp server)
RUN echo "mailhub=mail.scriptis.fr:587" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthUser=myecovillage@scriptis.fr" >> /etc/ssmtp/ssmtp.conf
RUN echo "AuthPass=dabEscPNSr" >> /etc/ssmtp/ssmtp.conf

RUN echo "UseTLS=YES" >> /etc/ssmtp/ssmtp.conf
RUN echo "UseSTARTTLS=YES" >> /etc/ssmtp/ssmtp.conf


# Set up php sendmail config
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini

RUN service apache2 restart

COPY . /var/www/html/php-framework

EXPOSE 80
LABEL org.opencontainers.image.source https://github.com/totodore/projet-app-myecovillage