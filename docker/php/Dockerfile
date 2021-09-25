FROM php:7.4.22-fpm

#ARG USER_ID
#ARG GROUP_ID

#ENV USER_ID=${USER_ID}
#ENV GROUP_ID=${GROUP_ID}

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        graphviz \
        libpq-dev \
        curl \
        git \
        procps \
        iputils-ping \
        nano \
        rsyslog \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv pdo_pgsql pdo pgsql bcmath pcntl \
    && pecl install redis \
    && pecl install xdebug-2.9.0 \
    && docker-php-ext-enable xdebug \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./ini/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./ini/php.ini /usr/local/etc/php/conf.d/php.ini

RUN mkdir -p /var/log/xhprof && mkdir -p /var/log/xdebug && touch /var/log/xdebug/access.log && chmod a+w /var/log/xdebug/access.log && chmod 777 /var/log/xhprof/ && chmod 777 /var/log/xdebug/ && chmod 777 /var/log/xdebug/access.log

# https://github.com/tideways/php-xhprof-extension
RUN cd /tmp && git clone https://github.com/tideways/php-xhprof-extension.git && cd php-xhprof-extension && phpize && ./configure && make && make install;

# RUN curl -s https://getcomposer.org/installer | php \
    # && mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl --silent --show-error https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.14

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN sed -i "s/33/$USER_ID/g" /etc/passwd
# RUN sed -i "s/33/$GROUP_ID/g" /etc/group

# Указываем рабочую директорию для PHP
WORKDIR /var/www

RUN mkdir -p /var/log/xdebug && touch /var/log/xdebug/access.log && chmod a+w /var/log/xdebug/access.log && chmod 777 /var/log/xdebug/ && chmod 777 /var/log/xdebug/access.log

# Запускаем контейнер
# Из документации: The main purpose of a CMD is to provide defaults for an executing container. These defaults can include an executable,
# or they can omit the executable, in which case you must specify an ENTRYPOINT instruction as well.
CMD ["php-fpm"]