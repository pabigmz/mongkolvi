FROM php:8.2-apache

# ติดตั้งไลบรารีที่จำเป็น
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql mbstring

# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ตั้งค่า Document Root
WORKDIR /var/www/html

# เปิดพอร์ตสำหรับ Apache
EXPOSE 80

# ตั้งค่าต่างๆ เมื่อ Container รัน
CMD ["apache2-foreground"]
