FROM php:8.0-fpm

# Install tools
RUN apt-get update && apt-get install -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install xdebug
RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql

# Set php.ini file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "date.timezone=Europe/Warsaw" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/php.ini
#    && echo "xdebug.output_dir=/code/var/xdebug_output" >> $PHP_INI_DIR/php.ini