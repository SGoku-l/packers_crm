FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev \
    libbrotli-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath opcache

# Install Swoole (without prompts)
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app into container
COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader

# Run Octane with Swoole
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
