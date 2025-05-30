#1 base image is php8.2
FROM php:8.2-fpm
RUN apt-get update  \
    && apt-get install -y \
    libpq-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip
# 3. Install Composer from composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy project files into the container
COPY . .

# 6. Install PHP dependencies
RUN composer install --no-interaction --prefer-dist

# 7. Expose port 9000 (PHP-FPM)
EXPOSE 9000
