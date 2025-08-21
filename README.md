# dev-tools

趣味で作った小粒なシステムたち

## local

docker 環境での提供

ローカル環境と公開環境を完全に一致するのは難しいのである程度割り切った構成

イメージのバージョンはできるだけ新しいもので安定版を選択

1: docker 一式のインストール

docker 公式イメージの選択

php イメージの選択 `php:8.4-apache-bullseye`
<https://hub.docker.com/_/php>
docker 内での composer の設定について
<https://getcomposer.org/doc/00-intro.md#docker-image>
laravel に必要な環境を選択
<https://laravel.com/>

2: dockerfile, docker-compose.yml の作成

3: docker 環境内でのフレームワーク(laravel)構築

`docker compose up --build`

立ち上げたコンテナの中に入る

`docker exec -it ctr-dev-tools bash`

公式ドキュメントに従いインストール開始

`composer global require laravel/installer`

laravel コマンドのパスは設定されなかった

```text
Changed current directory to /home/appuser/.config/composer
./composer.json has been created
Running composer update laravel/installer
Loading composer repositories with package information
Updating dependencies
```

上記のメッセージが出力されていた

laravel コマンドを実行したい時は下記の様に

`/home/appuser/.config/composer/vendor/laravel/installer/bin/laravel new dev-tools`

インストール時に出現する選択は全て標準で選択されてるものですすめる

インストール終了後、ディレクトリ構成を整える

```bash
mv -n dev-tools/* .
mv -n dev-tools/.[^\.]* .
```

README.md だけが残るがこれは今回は不要としておく、その後ディレクトリごと削除

```bash
rm -r dev-tools
```

コンテナを抜けてwebブラウザで確認

<http://localhost:8100/>

初期設定はデータベースはsqlite, `database/database.sqlite`

4: 通常の実装をする時の手順をまとめ
