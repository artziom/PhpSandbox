FROM php:8.0-fpm

# Set php.ini file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "date.timezone=Europe/Warsaw" >> $PHP_INI_DIR/php.ini

# Install xdebug
RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/php.ini

RUN apt-get update && apt-get install -y \
    zip libxml2-dev libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install composer && symfony
RUN curl -sS https://getcomposer.org/installer | php  \
    && mv composer.phar /usr/local/bin/composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN pecl install \
    apcu \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
    opcache intl pgsql pdo_pgsql \
    && docker-php-ext-enable \
    apcu