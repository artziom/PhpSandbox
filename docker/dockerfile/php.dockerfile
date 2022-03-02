FROM php:8.1-fpm

# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install tools
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libssl-dev libmemcached-dev zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Install xdebug, pdo_mysql, zip
RUN pecl install xdebug \
    && pecl install redis \
    && pecl install memcached \
    && pecl install mongodb \
    && pecl install xhprof \
	&& docker-php-ext-enable redis xdebug memcached mongodb xhprof \
    && docker-php-ext-install pdo_mysql zip

## Install Blackfire agent
#RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
#    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
#    && mkdir -p /tmp/blackfire \
#    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
#    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
#    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
#    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# Set php.ini file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=develop,debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.output_dir=/code/var/tmp/xdebug_output" >> $PHP_INI_DIR/php.ini \
    && echo "date.timezone=Europe/Warsaw" >> $PHP_INI_DIR/php.ini \
    && echo "xhprof.output_dir=/code/var/tmp/xhprof" >> $PHP_INI_DIR/php.ini