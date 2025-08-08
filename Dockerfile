FROM php:8.2-fpm

# Установка зависимостей
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
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    libssl-dev \
    && pecl install redis \
    && docker-php-ext-enable redis

# Очистка кеша
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install mbstring zip exif pcntl bcmath gd sockets pdo pdo_pgsql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка Node.js
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www

# Копирование файлов приложения
COPY . .

# Установка зависимостей
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Настройка прав
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage
RUN chmod -R 777 /var/www/bootstrap/cache

# Конфигурация php
COPY ./docker/php/uploads.ini /usr/local/etc/php/conf.d/

# Установка Reverb
RUN php artisan reverb:install

EXPOSE 9000
CMD ["php-fpm"]
