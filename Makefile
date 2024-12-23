include .env

start:
	docker compose up -d;

stop:
	docker compose down;

start-prod:
	docker compose -f docker-compose-prod.yml up -d;

prod-pull:
	git pull;
	make set-prod-perm;

set-prod-perm:
	chown -R www-data:www-data ./;
	chmod -R 775 ./storage ./bootstrap/cache;

deploy:
	make prod-pull;
	make migrate;
	make composer-install;
	make test;

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