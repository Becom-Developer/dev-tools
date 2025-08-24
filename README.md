# dev-tools

趣味で作った小粒なシステムたち

## Environment

環境構築の記録

- ローカル環境と公開環境を完全に一致するのは難しいのである程度割り切った構成にしたい
- 開発環境は変更する可能性があるので larave sail は使わず、自前で docker ファイルを用意
- laravel 公式サイトを参考にイメージのバージョンはできるだけ新しいもので安定版を選択

### local-env

- github でリポジトリを用意した後にローカル環境を用意
- docker 一式のインストール後、イメージを選択
- php イメージの選択 `php:8.4-apache-bullseye` <https://hub.docker.com/_/php>
- docker 内での composer の設定 <https://getcomposer.org/doc/00-intro.md#docker-image>

#### docker

dockerfile, docker-compose.yml の作成

`dockerfile`

```docker
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
```

`docker-compose.yml`

```docker
services:
  web:
    container_name: ctr-dev-tools
    build:
      context: .
    image: img-dev-tools
    ports:
      - '8100:80'
    volumes:
      - .:/usr/src/app
```

docker 環境内でのフレームワーク(laravel)構築

初動のイメージからコンテナの生成

```bash
docker compose up --build
```

立ち上げたコンテナの中に入る

```bash
docker exec -it ctr-dev-tools bash
```

下記はコンテナのなかでの作業

```bash
# 公式ドキュメントに従いインストール開始
composer global require laravel/installer
```

laravel コマンドのパスは設定されず、インストール途中に下記のメッセーがあった

```text
Changed current directory to /home/appuser/.config/composer
./composer.json has been created
Running composer update laravel/installer
Loading composer repositories with package information
Updating dependencies
```

laravel コマンドを実行したい時は下記の様に

```bash
/home/appuser/.config/composer/vendor/laravel/installer/bin/laravel new dev-tools
```

インストール時に出現する選択は全て標準で選択されてるものですすめ

初期設定のデータベース sqlite で構築しておく

インストール終了後、ディレクトリ構成を整える

```bash
mv -n dev-tools/* .
mv -n dev-tools/.[^\.]* .
```

README.md だけが残るがこれは今回は不要としておく、その後ディレクトリごと削除

```bash
rm -r dev-tools
```

コンテナを抜けてwebブラウザで確認 <http://localhost:8100/>

初期設定データベースはsqliteしたのでファイルができる: `database/database.sqlite`

違う OS で環境構築のことを考え、あえて下記のファイルは git で管理しない様にしておく

```bash
echo 'composer.lock' >> .gitignore
echo 'package-lock.json' >> .gitignore
```

### prod-env

ローカル側で構築したファイルを公開環境で展開

- コストと保守の手間を鑑みて、さくらのレンタルサーバーを活用
- 基本的には公式ブログの資料にそって構築 <https://knowledge.sakura.ad.jp/41775/>
- 初期時はsqliteで構築するのでMySQLの用意はしない
- node.js のインストールについて
  - ブログ記事では `20.9.0` を指定しているが `vite` インストールができないので新しいものを用意したい
  - `You are using Node.js 20.9.0. Vite requires Node.js version 20.19+ or 22.12+. Please upgrade your Node.js version.`

レンタルサーバー内のコンソールにて

```bash
$ nodenv install -l
20.19.4
22.18.0
24.6.0
graal+ce-19.2.1
graal+ce_java11-20.0.0
graal+ce_java8-20.0.0
```

22.18.0 はインストールできるはずだが、なぜかインストールでエラーがでる、おそらく 22 はインストールできない

```text
Last 10 log lines:
warning: unknown warning option '-Wno-old-style-declaration'; did you mean '-Wno-out-of-line-declaration'? [-Wunknown-warning-option]
gmake[1]: *** [deps/simdutf/simdutf.target.mk:86: /home/becom2022/tmp/node-build.20250824103859.67491.wwSvuQ/node-v22.18.0/out/Release/obj.target/simdutf/deps/simdutf/simdutf.o] Error 1
```

`20` の最終版をインストール

```bash
nice -n 20 nodenv install 20.19.4
nodenv rehash
# 切り替えておく
nodenv local 20.19.4
# 利用できる状態であることを確認
nodenv version
```

git リポジトリから配置してインストールするまでの流れ

```bash
cd ~/www
git clone git@github.com:Becom-Developer/dev-tools.git
cd dev-tools/
cp .env.example .env
composer update
php artisan key:generate
npm install
npm run build
php artisan migrate
```

webブラウザで確認: <https://becom2022.sakura.ne.jp/dev-tools/public/>

## References

- 公式: <https://laravel.com/>
- 日本語訳: <https://readouble.com/>
- dockerhub: <https://hub.docker.com>
- nodenv: <https://github.com/nodenv/nodenv>
- node.js: <https://nodejs.org/ja/>
