FROM php:7.3.9-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

ADD docker/shell/init_db.sh /tmp/init_db.sh

WORKDIR /var/www/order_accounting_system
