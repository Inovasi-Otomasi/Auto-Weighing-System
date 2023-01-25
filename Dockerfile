FROM php:8.1-apache
#testing2
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e "s!/var/www/html!$APACHE_DOCUMENT_ROOT!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!$APACHE_DOCUMENT_ROOT!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY src/ /var/www/html

RUN chown -R www-data:www-data /var/www
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
    libpng-dev libzip-dev

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd zip
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN composer install
RUN composer du

RUN php artisan key:generate
RUN php artisan migrate:refresh --seed
RUN php artisan optimize
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:cache
