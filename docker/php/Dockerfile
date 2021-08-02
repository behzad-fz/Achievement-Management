FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y \
    vim \
    git \
    zip \
    nano \
    curl \
    wget \
    tree \
    tmux \
    screen \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev\
    libonig-dev\
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libzip-dev \
    zip \
    g++

RUN docker-php-ext-install \
    gd \
    bz2 \
    intl \
    json \
    exif \
    phar \
    iconv \
    ctype \
    bcmath \
    mysqli \
    sockets \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    tokenizer \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN acurl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
RUN sudo apt-get install -y \
    nodejs \
    npm \
    build-essential

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/dev dev
RUN mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev

WORKDIR /srv/www

RUN chown -R dev:dev /var/www
