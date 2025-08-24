FROM php:8.4-apache-bullseye
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# apache 設定
ENV APACHE_DOCUMENT_ROOT=/usr/src/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set the 'ServerName' directive globally to suppress this message 対策
RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn

# laravel インストール用
RUN apt update
RUN apt install -y git unzip

# フロント周りのライブラリ(lts の最新版にあわせる)
RUN apt install -y nodejs
RUN apt install -y npm
RUN npm install -g n
RUN n lts

# ユーザーを作成後切り替え
RUN useradd -s /bin/bash -m -u 1000 appuser
USER 1000
