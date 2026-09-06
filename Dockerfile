FROM php:8.3-apache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    libssl-dev \
    unzip \
    && pecl install mongodb-2.3.3 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY . /var/www/html/

RUN mkdir -p /var/www/html/Images && chown -R www-data:www-data /var/www/html/Images
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/Images

RUN echo "default_charset = UTF-8" > /usr/local/etc/php/conf.d/charset.ini

WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist

RUN echo '<Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
        </directory>' > /etc/apache2/conf-available/app.conf \
        && a2enconf app

EXPOSE 80