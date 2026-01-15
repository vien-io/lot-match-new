# My Dockerfile

# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    npm \
    nodejs \
    libpq-dev \
    openssl \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Enable Apache modules
RUN a2enmod rewrite ssl
RUN a2ensite default-ssl

# Generate self-signed SSL certificate
RUN mkdir -p /etc/apache2/ssl \
    && openssl req -x509 -nodes -days 365 \
        -newkey rsa:2048 \
        -keyout /etc/apache2/ssl/apache.key \
        -out /etc/apache2/ssl/apache.crt \
        -subj "/C=PH/ST=Manila/L=Manila/O=LotMatch/CN=localhost"

# Configure Apache SSL site to use our cert
RUN sed -i 's|SSLCertificateFile.*|SSLCertificateFile /etc/apache2/ssl/apache.crt|' /etc/apache2/sites-available/default-ssl.conf \
    && sed -i 's|SSLCertificateKeyFile.*|SSLCertificateKeyFile /etc/apache2/ssl/apache.key|' /etc/apache2/sites-available/default-ssl.conf \
    && a2ensite default-ssl

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set Apache document root to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache configs to point to Laravel public/
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP and Node dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80 and 443
EXPOSE 80 443

# Use entrypoint to dynamically use Render PORT
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]








