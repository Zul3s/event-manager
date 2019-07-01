USER_ID = $(shell id -u)
GROUP_ID = $(shell id -g)

export UID = $(USER_ID)
export GID = $(GROUP_ID)

DOCKER_COMPOSE_DEV = docker-compose -p event_manager
DOCKER_COMPOSE_PROD = docker-compose -p event_manager_prod -f docker-compose.yml -f docker-compose.prod.yml

help: ## Display available commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# =====================================================================
# Install =============================================================
# =====================================================================

install: ## Install docker stack, assets and vendors
	$(DOCKER_COMPOSE_DEV) build
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'make deps-install'

db-migrate: ## Run database migration into the mysql container
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:migration:migrate'

deps-install: ## Install composer vendor and setup assets
	php bin/composer install

# =====================================================================
# Development =========================================================
# =====================================================================

start: ## Start all the stack (you can access the project on localhost:8080 after that)
	@-docker network create even_manager_stack
	$(DOCKER_COMPOSE_DEV) up -d
	@docker network connect --alias even_manager even_manager_stack $$(docker ps --filter "name=event_manager_php_*" -q)

stop: ## Stop all the containers that belongs to the project
	@-docker network disconnect even_manager_stack $$(docker ps --filter "name=event_manager_php_*" -q)
	$(DOCKER_COMPOSE_DEV) down

connect: ## Connect on a remote bash terminal on the php container
	$(DOCKER_COMPOSE_DEV) exec php bash

log: ## Show logs from php container
	$(DOCKER_COMPOSE_DEV) logs -f php