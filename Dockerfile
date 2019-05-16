Dockerfile:
FROM php:7.3-cli
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable opcache \
    && docker-php-source delete
