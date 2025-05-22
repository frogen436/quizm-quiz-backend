FROM php:8.2-fpm-alpine

# 1) Системные зависимости и расширения PHP
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libpq libpq-dev \
    libzip-dev \
    zip \
  && docker-php-ext-install pdo pgsql pdo_pgsql zip \
  && docker-php-ext-enable pgsql pdo_pgsql

# 2) Composer
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_PREFERS_DIST=1
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3) Git-safe (для VCS-загрузчиков)
RUN git config --global --add safe.directory /var/www/html

# 4) Копируем файлы, нужные до composer install
COPY composer.json composer.lock ./
COPY artisan ./
COPY bootstrap bootstrap
COPY config config
COPY routes routes

# 5) Устанавливаем зависимости
RUN composer install --no-interaction --optimize-autoloader --no-dev --prefer-dist

# 6) Копируем остальной код (vendor игнорируется через .dockerignore)
COPY . .

# 7) Права на каталоги
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
