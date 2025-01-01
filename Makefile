include .env

start:
	docker compose up -d;

stop:
	docker compose down;

start-prod:
	docker compose -f docker-compose-prod.yml up -d;

stop-prod:
	docker compose -f docker-compose-prod.yml down;

prod-pull:
	git pull;
	make set-prod-perm;

deploy:
	make prod-pull;
	make migrate;
	make composer-install;
	make test;

fpm-restart:
	docker exec -it assistant-app kill -USR2 1

backup-db:
	docker exec assistant-db pg_dump -U $(DB_USERNAME) -d $(DB_DATABASE) > $(DB_LOCAL_BACKUP_PATH)/$(shell date +%Y-%m-%d_%H-%M-%S).sql
	chown -R $(DB_LOCAL_BACKUP_OWNER):$(DB_LOCAL_BACKUP_OWNER) $(DB_LOCAL_BACKUP_PATH);
	echo "Database backup created successfully"

backup-public:
	cp -r ./storage/app/public $(APP_PUBLIC_BACKUP_PATH)
	chown -R $(APP_PUBLIC_BACKUP_OWNER):$(APP_PUBLIC_BACKUP_OWNER) $(APP_PUBLIC_BACKUP_PATH);

restore-db: # with param file=path/to/backup
	docker exec -i assistant-db psql -U $(DB_USERNAME) -d $(DB_DATABASE) < $(file)
	echo "Database restored successfully"

# ========================================================= migrations / entity ==========================================
mc:
	docker exec -it assistant-app bin/console doctrine:migrations:generate

m:
	docker exec -it assistant-app bin/console doctrine:migrations:migrate

mr:
	docker exec -it assistant-app bin/console doctrine:migrations:migrate prev

md:
	docker exec -it assistant-app bin/console doctrine:migrations:diff

ec: # name=... Название сущности
	docker exec -it assistant-app bin/console make:entity $(name)

# ========================================================= COMPOSER/APP ==========================================
composer-install:
	docker exec -it assistant-app composer install -n;

composer-update:
	docker exec -it assistant-app composer update -n;

composer-update-package: # Вызывается с параметром package=xxx
	docker exec -it assistant-app composer update -n -W $(package);

composer-req: # Вызывается с параметром package=xxx
	docker exec -it assistant-app composer require $(package)

composer-remove: # Вызывается с параметром package=xxx
	docker exec -it assistant-app composer remove $(package)

back-bash:
	docker exec -it assistant-app bash;

pgs-bash:
	docker exec -it assistant-db bash;


# ========================================================= PRODUCTION COMMANDS ==========================================
clear-cache-prod:
	docker exec -it assistant-app bin/console cache:clear --env=prod

jwt-gen:
	docker exec -it assistant-app bin/console lexik:jwt:generate-keypair

jwt-gen-overwrite:
	docker exec -it assistant-app bin/console lexik:jwt:generate-keypair --overwrite