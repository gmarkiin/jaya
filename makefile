#!/usr/bin/make

# choco install make

.DEFAULT_GOAL := help
##@ Bash shortcuts

jaya_nginx:
	docker compose exec --user application jaya_nginx bash

migrate:
	docker compose exec --user application jaya_nginx php artisan migrate

fresh:
	docker compose exec --user application jaya_nginx php artisan migrate:fresh

install:
	docker compose exec jaya_nginx bash -c "su -c \"composer install\" application"

route:
	docker compose exec --user application jaya_nginx php artisan route:list

test:
	docker compose exec --user application jaya_nginx php artisan test

coverage:
	docker compose exec --user application jaya_nginx php artisan test --coverage
