FROM php:8.3-fpm

# Set working directory
WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql intl \
    && docker-php-ext-enable intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install Symfony dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8000

# Run Symfony server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
