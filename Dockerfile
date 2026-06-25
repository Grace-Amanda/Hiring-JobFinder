FROM php:8.2-fpm

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file proyek ke dalam container
COPY . .

# Install dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Beri izin pada folder storage
RUN chmod -R 775 storage bootstrap/cache
