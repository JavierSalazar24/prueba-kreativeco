FROM php:8.2-cli

WORKDIR /app

COPY . /app

# Instalar dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ejecutar composer install
RUN composer install --no-dev --optimize-autoloader && composer dump-autoload

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
