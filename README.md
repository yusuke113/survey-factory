# アンケートファクトリー

## 開発するには

### アプリケーションの起動

以下のコマンドを実行してアプリケーションを起動します。

1. ホストPC上でdockerが起動していることを確認
2. 下記コマンドを実行

- プロジェクトを作成したいフォルダ内で(SSH)
```bash
git clone git@github.com:yusuke113/survey-factory.git && cd survey-factory && make init
```

3. ターミナルでmake 下記コマンドを実行し、コンテナのステータスが全てUpになっていることを確認

```bash
make ps
```

4. Postmanで[localhost/api/health](http://localhost:8080/api/health)にアクセスして{"message": "OK"}のレスポンスが返却されること確認
※Postmanが手元にない方はブラウザからでも可
これでサイトにアクセスできます。

- バックエンド
http://localhost:8080/api/health
- フロントエンド
http://localhost:3333/

### APIルーティングの確認方法

```
docker-compose exec api php artisan route:list
```

## API仕様書
https://github.com/yusuke113/survey-factory/blob/main/document/api/openapi.yaml
