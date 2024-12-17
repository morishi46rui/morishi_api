FROM php:8.3.11-fpm

# 必要な依存関係をインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションをコピー
WORKDIR /var/www/html
COPY . .

# 権限の設定
RUN chown -R www-data:www-data /var/www/html

# Laravelのサーバーを起動
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
