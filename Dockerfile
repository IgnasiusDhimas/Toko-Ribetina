FROM php:8.2-cli

# Install dependencies + GD
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip unzip git curl libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-interaction --no-progress

# Expose port (Railway inject PORT env)
EXPOSE 8000

# Start Laravel via PHP built-in server
CMD php -r '$port = getenv("PORT") ?: 8000; passthru("php -S 0.0.0.0:$port -t public");'