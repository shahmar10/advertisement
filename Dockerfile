FROM php:8.1-fpm-alpine

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libzip-dev sqlite-dev \
            libpng-dev libxml2-dev oniguruma-dev libmcrypt-dev curl curl-dev libcurl  \
            linux-headers freetype-dev libjpeg-turbo-dev libwebp-dev zlib-dev

# Install required libraries
RUN apk add --no-cache libpng libzip  libgd  libxpm  libpng  libjpeg-turbo

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY ./ ./

RUN chown -R www-data:www-data /app/storage
RUN chmod -R ug+w /app/storage
RUN chmod 777 -R /app/storage
RUN chmod 777 -R /app/public


RUN composer install --no-interaction --no-progress --no-suggest \
    && composer clear-cache \
    && apk del .build-deps

EXPOSE 9000

RUN php artisan storage:link

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]

