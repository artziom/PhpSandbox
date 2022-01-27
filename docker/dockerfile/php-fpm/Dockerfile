FROM php:8.0-fpm

# Set php.ini file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "date.timezone=Europe/Warsaw" >> $PHP_INI_DIR/php.ini

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install xdebug
RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug \
    && echo "xdebug.client_host=host.docker.internal" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=trigger" >> $PHP_INI_DIR/php.ini

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list \
    && apt-get update && apt-get install -y \
    symfony-cli \
    zip libxml2-dev libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install APCU, OPCACHE, INTL
RUN pecl install apcu \
    && docker-php-ext-install opcache intl \
    && docker-php-ext-enable apcu

# Install database extensions
RUN docker-php-ext-install pdo_mysql

# Git default configuration
ARG USER_NAME
ARG USER_EMAIL
RUN git config --global user.email $USER_NAME \
    && git config --global user.name $USER_EMAIL

RUN apt-get update && apt-get install -y \
    zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install GD
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd