# ベースイメージ
FROM php:8.2-fpm

# 作業ディレクトリを設定
WORKDIR /var/www

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    pkg-config

# GDライブラリのインストール
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

# PHP拡張モジュールのインストール
RUN docker-php-ext-install -j$(nproc) bcmath pdo pdo_mysql mbstring intl xml zip

# Composerのインストール
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# コンテナが起動した時に起動するコマンド
CMD ["php-fpm"]

# 9000ポートを開放
EXPOSE 9000
