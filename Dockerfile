FROM php:8-apache

LABEL maintainer="Andreas Kasper <andreas.kasper@goo1.de>"

RUN a2enmod rewrite

ADD html/ /var/www/html/
