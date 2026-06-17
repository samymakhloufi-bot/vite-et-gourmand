FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mysqli

    RUN a2enmod rewrite

    COPY . /var/www/html/

    RUN chown -R www-data:www-data /var/www/html

    RUN echo '<Directory /var/www/html>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
        </directory>' > /etc/apache2/conf-available/app.conf \
        && a2enconf app

        EXPOSE 80