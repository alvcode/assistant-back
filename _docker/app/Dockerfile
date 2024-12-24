FROM php:8.2.27-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libonig-dev \
      libicu-dev \
      zip unzip \
      autoconf \
      gcc \
      make \
      procps \
      git && \
      docker-php-ext-install pdo_pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install mbstring && \
      docker-php-ext-install sockets && \
      docker-php-ext-configure intl && \
      docker-php-ext-install intl && \
      docker-php-ext-install opcache && \
      apt-get install -y libmagickwand-dev && \
      pecl install imagick && \
      docker-php-ext-enable imagick && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN echo "zend_extension=$(php-config --extension-dir)/opcache.so" >> /usr/local/etc/php/conf.d/xdebug.ini
COPY ./_docker/app/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www