THIS_DIR := $(dir $(abspath $(firstword $(MAKEFILE_LIST))))

# Variables
IMAGE_NAME = upmind-sdk-php
CONTAINER_NAME = upmind-sdk-php
MOUNT_DIR = /upmind-sdk-php

## —— 🎵 🐳 The Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen.
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


build: ## Build the Docker image
	docker build -t $(IMAGE_NAME) .

start: ## Run the Docker container in the background
	docker run -d --name $(CONTAINER_NAME) -v $(PWD):$(MOUNT_DIR) $(IMAGE_NAME)

stop: ## Stop the Docker container
	docker stop $(CONTAINER_NAME)

sh: ## Get a shell into the running Docker container
	docker exec -it $(CONTAINER_NAME) /bin/bash

clean: ## Clean target
	docker rm -f $(CONTAINER_NAME)
	docker rmi $(IMAGE_NAME)