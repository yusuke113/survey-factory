# TODOアプリ

## 開発するには

### アプリケーションの起動

以下のコマンドを実行してアプリケーションを起動します。

```bash
# プロジェクトを作成したいフォルダ内で(SSH)
git clone git@github.com:yusuke113/Todo-Train.git

#ディレクトリの移動
cd Todo-Train

# Dockerの起動
docker-compose up -d --build

# APIに必要なライブラリをインストール
docker-compose exec api composer install

# .env作成
docker-compose exec api cp .env.example .env

# アプリケーションキー作成
docker-compose exec api php artisan key:generate

# Clientに必要なライブラリをインストール
docker-compose run client npm install --no-optional

# データベースのマイグレーション
docker-compose exec api php artisan migrate:fresh --seed

docker-compose up -d
```

これでサイトにアクセスできます。

http://localhost:3333/

### APIルーティングの確認方法

```
docker-compose exec api php artisan route:list
```

## API仕様書

https://github.com/yusuke113/Todo-Train/blob/develop/document/api/openapi.yaml
