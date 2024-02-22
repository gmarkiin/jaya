#!/usr/bin/make

# choco install make

.DEFAULT_GOAL := help
##@ Bash shortcuts

jaya_nginx: ## Enter bash jaya_nginx container
	docker compose exec --user application jaya_nginx bash

mysql: ## Enter bash mysql container
	docker compose exec mysql bash

##@ Database tools

migration: ## Create migration file
	docker compose exec --user application jaya_nginx bash -c "php artisan make:migration $(name)"

migrate: ## Perform migrations
	docker compose exec --user application jaya_nginx php artisan migrate

fresh: ## Perform migrations
	docker compose exec --user application jaya_nginx php artisan migrate:fresh

rollback: ## Rollback migration
	docker compose exec --user application jaya_nginx php artisan migrate:rollback

##@ Composer

install: ## Composer install dependencies
	docker compose exec jaya_nginx bash -c "su -c \"composer install\" application"

update: ## Composer install dependencies
	docker compose exec --user application jaya_nginx bash -c "composer update"

##@ General commands

route: ## List the routes of the app
	docker compose exec --user application jaya_nginx php artisan route:list

test: ## List the routes of the app
	docker compose exec --user application jaya_nginx php artisan test

