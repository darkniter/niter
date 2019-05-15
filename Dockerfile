FROM php:7.3-cli
RUN docker-php-ext-install mysqli && docker-php-source delete
