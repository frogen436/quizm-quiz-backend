# Dockerfile

# Используем официальный образ PHP с FPM и необходимыми расширениями
FROM php:8.2-fpm-alpine

# Устанавливаем системные зависимости и расширения PHP
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libpq libpq-dev \
    libzip-dev \
    zip \
  && docker-php-ext-install pdo pgsql pdo_pgsql zip \
  && docker-php-ext-enable pgsql pdo_pgsql

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копируем проект
COPY . /var/www/html

# Разрешаем Git безопасно работать с этой директорией (убирает ошибку «dubious ownership»)
RUN git config --global --add safe.directory /var/www/html

# Устанавливаем зависимости Composer (без dev-пакетов)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Копируем пользовательский php.ini для включения расширений (если нужен свой ini)
COPY docker/php/php.ini /usr/local/etc/php/php.ini

# Даем права на папки хранения кэша и логов
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose порт для FPM
EXPOSE 9000

CMD ["php-fpm"]
