THIS_DIR := $(dir $(abspath $(firstword $(MAKEFILE_LIST))))

DOCKER = docker compose
DOCKER_COMP = docker compose
CONTAINER_NAME = upmind-sdk-php

## —— 🎵 🐳 The Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen.
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

build: ## Build the Docker image
	@$(DOCKER_COMP) build
	@$(DOCKER_COMP) up -d --force-recreate
	@$(DOCKER_COMP) exec $(CONTAINER_NAME) composer install --no-scripts -n

start: ## Run the Docker container in the background
	@$(DOCKER_COMP) up -d --force-recreate

stop: ## Stop container
	@$(DOCKER_COMP) stop

sh: ## Make sh on container
	@$(DOCKER_COMP) exec -ti $(CONTAINER_NAME) sh

outdated: ## Check for outdated vendors
	@$(DOCKER_COMP) exec $(CONTAINER_NAME) composer outdated

#tests: ## Run unittests
#	@$(DOCKER_COMP) exec -ti cls-client sh -c "./vendor/bin/phpunit --verbose --no-coverage -c ./phpunit.xml.dist tests"

stan:
	docker exec -it $(CONTAINER_NAME) ./vendor/bin/phpstan analyse --memory-limit=1G