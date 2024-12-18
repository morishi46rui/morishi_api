FROM php:8.3.11-fpm

# ビルドキャッシュの削除を無効化
# 参考: https://github.com/moby/buildkit/blob/master/frontend/dockerfile/docs/reference.md#run---mounttypecache
RUN rm -f /etc/apt/apt.conf.d/docker-clean; echo 'Binary::apt::APT::Keep-Downloaded-Packages "true";' > /etc/apt/apt.conf.d/keep-cache

# 必要なライブラリのインストール
RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    locales \
    cron \
    && docker-php-ext-install mbstring exif pcntl bcmath gd pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# spectral CLI(API linter)のインストール
RUN curl -L https://raw.github.com/stoplightio/spectral/master/scripts/install.sh | sh

# 日本語設定
RUN echo "ja_JP.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Laravelプロジェクトのファイルをコンテナにコピー
COPY . /var/www/

# rootユーザーでcomposerインストールを許可
ENV COMPOSER_ALLOW_SUPERUSER=1

# Composerを使ってLaravelプロジェクトの依存関係をインストール
RUN composer install

# 権限の設定
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# storageのシンボリックリンク作成
RUN php artisan storage:link

# cronジョブの設定
COPY crontab /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron

CMD ["sh", "-c", "cron && php-fpm"]
