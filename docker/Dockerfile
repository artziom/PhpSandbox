FROM php:8.0.0-apache

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install tools
RUN apt-get update && apt-get install -y \
        libzip-dev unzip

# Install xdebug, pdo_mysql, zip
RUN pecl install xdebug-3.0.1 \
	&& docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql zip

# Set php.ini file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=develop,debug,coverage,gcstats,profile,trace" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/php.ini \
    && echo "date.timezone=Europe/Warsaw" >> $PHP_INI_DIR/php.ini