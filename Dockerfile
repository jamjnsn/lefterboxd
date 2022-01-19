FROM php:7.4-apache

# Arguments defined in docker-compose.yml
ENV PUID 1000
ENV PGID 1000

# Add nodesource
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cconfigure Apache
COPY apache.conf /etc/apache2/sites-enabled/lefterboxd.conf
RUN a2enmod rewrite && \
    rm /etc/apache2/sites-enabled/000-default.conf && \
    chown www-data:www-data /etc/apache2/sites-enabled/lefterboxd.conf

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Volumes
VOLUME ["/var/www/storage"]

# Copy build
COPY --chown=${PUID}:${PGID} . /var/www

# Create system user to run Composer and Artisan Commands
RUN groupadd -g ${PGID} lefterboxd
RUN useradd -G www-data,root -u ${PUID} -g ${PGID} -d /home/lefterboxd lefterboxd
RUN mkdir -p /home/lefterboxd/.composer && \
    chown -R ${PUID}:${PGID} /home/lefterboxd

# Set working directory
WORKDIR /var/www

# Composer
RUN composer install

# Build NPM
RUN npm i && npm run prod

USER $PUID
