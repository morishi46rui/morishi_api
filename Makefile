# build && ホストマシンにパッケージインストール
build:
	docker compose build && make modb
buildn:
	docker compose build --no-cache && make modb
buildb:
	docker compose build app && make modb

# buildせずパッケージをインストール
modb:
	docker compose run --rm app composer install

# 起動
up:
	docker compose up
upd:
	docker compose up -d

# 再起動
re:
	docker compose restart

# シャットダウン
down:
	docker compose down --remove-orphans

# コンテナ内に入る
b:
	docker compose exec app bash

# 初期データ投入
seed:
	docker compose exec app bash -c "php artisan migrate:fresh && php artisan db:seed"

# volume以外を削除
prune:
	docker system prune

# lintとformat
fix:
	make fixb

fixb:
	docker compose up -d db && \
	docker compose run --rm app php artisan clockwork:clean -a && \
	docker compose run --rm app bash -c "vendor/bin/pint && \
	vendor/bin/phpcbf --standard=PSR12 app/ && \
	vendor/bin/psalm && \
	vendor/bin/phpmd app/ text phpmd.xml && \
	vendor/bin/phpcs --standard=PSR12 app/ && \
	php artisan test || true"

# OpenApi Schemaの生成/更新
api:
	chmod 777 backend/storage/api-docs/api-docs.json && \
	docker compose run --rm app bash -c "php artisan openapi:generate-routes && \
	php artisan l5-swagger:generate && \
	spectral lint storage/api-docs/api-docs.json"

# 開発環境構築
init:
	cp ./app/.env.example ./app/.env && \
	make buildn && \
	make upd && \
	make seed && \
	docker compose exec -it db mysql -u root -p -e \
	"SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'laraveltest';" \
	| grep -q laraveltest || docker compose exec -it db mysql -u root -p -e "CREATE DATABASE laraveltest;"

cho:
	chown -R www-data app/storage
	docker compose exec app chmod -R a+w /var/www/bootstrap/cache
