MAKEFILE_DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

help:
	@echo '---------- 環境構築に関するコマンド -----------'
	@echo 'init                   -- プロジェクト初期のセットアップを行います※基本的にクローンしてきて1回目のみ実行'
	@echo 'remake                 -- 環境を作り直します※dockerの構成等変更になったらこのコマンドを実行してください'
	@echo ''
	@echo "\033[1;34m---------- Dockerに関するコマンド ----------\033[0m"
	@echo 'ps                     -- コンテナ一覧を表示します'
	@echo 'build                  -- 全コンテナイメージをビルドします'
	@echo 'up                     -- 全コンテナを作成後、コンテナを起動します'
	@echo 'up-prod                -- 本番モードで全コンテナを作成後、コンテナを起動します'
	@echo 'restart                -- 全コンテナを作り直した後起動します ※image、volumeは既存のものを再利用'
	@echo 'down                   -- 全コンテナを削除します'
	@echo 'destroy                -- コンテナ、ネットワーク、イメージ、ボリュームを削除します'
	@echo ''
	@echo "\033[1;34m---------- apiコンテナに関するコマンド ----------\033[0m"
	@echo 'api-bash               -- apiコンテナに接続します'
	@echo 'tinker                 -- apiコンテナでtinkerを起動します'
	@echo 'phpunit                -- APIのユニットテストを実行します'
	@echo 'phpcs                  -- コードの規約チェックを行います'
	@echo 'phpmd                  -- コードを解析し、実装上の問題点を検出します'
	@echo ''
	@echo "\033[1;34m---------- DBに関するコマンド ----------\033[0m"
	@echo 'db                     -- dbコンテナに接続します'
	@echo 'sql                    -- dbコンテナのmakinaデータベースに直接接続します'
	@echo 'migrate                -- DBのマイグレートを実行します'
	@echo 'migrate-status         -- DBのマイグレート状態を確認します'
	@echo 'fresh                  -- DBのテーブルを作り直します'
	@echo 'fresh-seed             -- DBのテーブルとシーディングを作り直します'
	@echo 'seed                   -- テーブルにデータをシーディングします'
	@echo 'rollback               -- DBのマイグレートの状態を一つ戻します'
	@echo ''
	@echo "\033[1;34m---------- clientコンテナに関するコマンド ----------\033[0m"
	@echo 'client-sh                 -- clientコンテナに接続します'
	@echo 'npm-install            -- clientコンテナで依存モジュール群をインストールします'
	@echo ''
	@echo '---------- Gitに関するコマンド ----------'
	@echo 'gs                     -- Gitステータスを確認'
	@echo 'gl                     -- Gitコミットログを確認'
	@echo 'gl-ol                  -- Gitコミットログをワンラインで確認'
	@echo '---------- 便利ツールに関するコマンド ----------'
	@echo 'open                   -- ブラウザで開発環境のページをブラウザで開く'
	@echo 'open-prod              -- ブラウザで本番環境のページをブラウザで開く'

init:
	@echo "\033[1;32mDocker環境のセットアップ中...\033[0m"
	@make create-network
	@make build
	@make up
	docker-compose exec api cp .env.example .env
	docker-compose exec api composer install
	docker-compose exec api php artisan key:generate
	docker-compose run --rm client npm i
	@make migrate
	@make seed
	@make up

remake:
	@echo "\033[1;32mDocker環境削除中...\033[0m"
	@make destroy
	@echo "\033[1;32mDocker環境のセットアップ中...\033[0m"
	@make create-network
	@make build
	@make up
	docker-compose exec api cp .env.example .env
	docker-compose exec api composer install
	docker-compose exec api php artisan key:generate
	docker-compose run --rm client npm i
	@make migrate
	@make seed
	@make up

create-network:
	-@docker network create survey-factory_net

ps:
	docker ps -a
build:
	docker-compose build --no-cache --force-rm
up:
	docker-compose up -d
up-prod:
	docker-compose -f docker-compose.prod.yml build
	docker-compose -f docker-compose.prod.yml run --rm client npm run build
	docker-compose -f docker-compose.prod.yml up -d
down:
	docker-compose down
	@make tele
restart:
	docker-compose down
	docker-compose up -d
destroy:
	docker-compose down --rmi all --volumes --remove-orphans

api-bash:
	docker-compose exec api bash
tinker:
	docker-compose exec api php artisan tinker
phpunit:
	docker-compose exec api ./vendor/bin/phpunit
phpcs:
	docker-compose exec api ./vendor/bin/phpcs --standard=./phpcs.xml .
phpmd:
	docker-compose exec api ./vendor/bin/phpmd ./app,./database/factories,./database/migrations,./routes/api.php,./tests ansi ./phpmd.xml
tele:
	@echo "\033[1;33m---------- telescope関連テーブルのレコードを削除 ----------\033[0m"
	-@docker-compose exec api php artisan telescope:prune --hours=0

db:
	docker-compose exec db bash
sql:
	docker-compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'

migrate:
	docker-compose exec api php artisan migrate
migrate-status:
	docker-compose exec api php artisan migrate:status
fresh:
	docker-compose exec api php artisan migrate:fresh
fresh-seed:
	docker-compose exec api php artisan migrate:fresh --seed
seed:
	docker-compose exec api php artisan db:seed
rollback:
	docker-compose exec api php artisan migrate:rollback

client-sh:
	docker-compose exec client sh
npm-install:
	docker-compose exec client npm i

gs:
	git status
gl:
	git log
gl-ol:
	git log --oneline

open:
	open http://localhost:3333
open-prod:
	open http://localhost:4444