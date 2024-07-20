FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    sudo \
    unzip \
    npm \
    nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy php.ini-production to php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Update php.ini
RUN sed -i 's/max_execution_time = .*/max_execution_time = 80/' /usr/local/etc/php/php.ini
RUN sed -i 's/max_input_time = .*/max_input_time = 80/' /usr/local/etc/php/php.ini
RUN sed -i 's/memory_limit = .*/memory_limit = 2048M/' /usr/local/etc/php/php.ini
RUN sed -i 's/post_max_size = .*/post_max_size = 50M/' /usr/local/etc/php/php.ini
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 50M/' /usr/local/etc/php/php.ini

WORKDIR /var/www/html