# FROM php:7.4
# COPY . /app
# RUN make /app
# CMD python /app/app.py
# RUN echo "Hello"

FROM php:7.3-fpm

# Arguments defined in docker-compose.yml
ARG user=sera
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unixodbc-dev \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
          && pecl install sqlsrv pdo_sqlsrv xdebug redis \
          && docker-php-ext-enable pdo_sqlsrv redis 

# Get latest Composerpecl
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# COPY ../sera /var/www/

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# VOLUME ["/var/www/html"]
# Set working directory
WORKDIR /var/www/html
# COPY . .

# USER $user