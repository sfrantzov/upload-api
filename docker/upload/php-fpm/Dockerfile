FROM php:7.2-fpm

ENV XDEBUG_VERSION 2.6.0

RUN apt-get update && apt-get -y install \
        git g++ libcurl4-gnutls-dev libicu-dev libmcrypt-dev libpq-dev libxml2-dev unzip zlib1g-dev \
    && docker-php-ext-install curl intl json mbstring pdo pdo_mysql xml bcmath \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && pecl install xdebug-${XDEBUG_VERSION} && docker-php-ext-enable xdebug \
    && apt-get autoremove -y && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

RUN echo 'date.timezone="Europe/Sofia"' >>  /usr/local/etc/php/conf.d/date.ini
RUN echo 'session.save_path = "/tmp"' >>  /usr/local/etc/php/conf.d/session.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN curl -sSL https://phar.phpunit.de/phpunit.phar -o /usr/bin/phpunit && chmod +x /usr/bin/phpunit

# set www-data user to match the home user
RUN groupmod -g 1000 www-data && usermod -u 1000 -g 1000 www-data
USER www-data

CMD ["php-fpm", \
        "--nodaemonize"]

