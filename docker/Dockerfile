FROM php:8.0.0-apache

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        libzip-dev unzip \
    # xdebug
	&& pecl install xdebug-3.0.1 \
	&& docker-php-ext-enable xdebug \
	&& mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
	&& echo "xdebug.mode=debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    # pdo_mysql zip
    && docker-php-ext-install pdo_mysql zip