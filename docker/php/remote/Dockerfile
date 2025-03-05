FROM php:8.3.0-fpm-alpine3.17

ARG APP_USER
ARG SENTRY_RELEASE

COPY --from=mlocati/php-extension-installer:1.5.52 /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:2.5.1 /usr/bin/composer /usr/local/bin/

RUN apk --update --no-cache add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata

RUN apk add --update --no-cache \
    libmcrypt-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    mysql-client \
    libzip-dev \
    zip \
    unzip \
    vim \
    aws-cli

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j"$(nproc)" gd pdo_mysql zip bcmath opcache

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY ./docker/php/remote/php.ini /usr/local/etc/php/conf.d/php.ini

RUN adduser -h /home/${APP_USER} -s /bin/ash -D -u 1000 ${APP_USER}

WORKDIR /var/www

COPY . .

RUN composer install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest

RUN chmod -R a+w storage/ bootstrap/cache
