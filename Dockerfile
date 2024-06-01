FROM php:8.1.0-apache

SHELL ["/bin/bash", "-l", "-euxo", "pipefail", "-c"]

COPY laravel-app /var/www/html
WORKDIR /var/www/html

# Mod Rewrite
RUN a2enmod rewrite

# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    npm 

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN rm /bin/sh && ln -s /bin/bash /bin/sh

ENV NVM_DIR /usr/local/nvm

RUN mkdir -p "$NVM_DIR"; \
    curl -o- \
        "https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh" | \
        bash \
    ; \
    source $NVM_DIR/nvm.sh; \
    nvm install --lts --latest-npm

RUN command -v nvm; \
    command -v node; \
    node --version; \
    command -v npm; \
    npm --version

RUN chown www-data:www-data /var/www/html -R