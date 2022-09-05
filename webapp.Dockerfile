FROM php:7.4-apache
RUN apt-get update
# Installing development packages.
RUN apt-get install -y \
    git \
    curl \
    zip \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    g++

# By default, php-apache's image uses the /var/www/html directory, we're changing that here to Laravel's pattern.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enabling site's host.
RUN a2enmod rewrite headers

# Configuring php.ini
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip

# Installing composer from docker image.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Solves laravel permission errors.
ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}
RUN addgroup -gid ${GID} --system laravel
RUN adduser --gid ${GID} --system --disabled-password --shell /bin/sh -u ${UID} laravel
RUN sed -i "s/export APACHE_RUN_USER/export APACHE_RUN_USER=laravel/g" /etc/apache2/envvars
RUN sed -i "s/export APACHE_RUN_GROUP/export APACHE_RUN_GROUP=laravel/g" /etc/apache2/envvars
RUN chown laravel:laravel -R /var/www/html