# Variables
IMAGE_NAME=sadaqa_back
DOCKER_HUB_USERNAME=mehdibe
DOCKER_HUB_REPO=sadaqa-backend
ALIAS:=sadaqa
SSH:="C:\Program Files\Git\usr\bin\ssh.exe"
REMOTE_DIR=../var/www/sadaqa
COMPOSE_FILE=docker-compose.yml

# Cibles
.PHONY: all build push deploy clean

all: build push deploy

build:
	@echo "Building Docker image..."
	docker build -t $(IMAGE_NAME) .

push:
	@echo "Pushing Docker image to Docker Hub..."
	docker tag $(IMAGE_NAME) $(DOCKER_HUB_USERNAME)/$(DOCKER_HUB_REPO):latest
	docker push $(DOCKER_HUB_USERNAME)/$(DOCKER_HUB_REPO):latest

deploy:
	$(SSH) $(ALIAS) "cd $(REMOTE_DIR) && docker-compose down && docker rmi $(DOCKER_HUB_USERNAME)/$(DOCKER_HUB_REPO) && docker pull $(DOCKER_HUB_USERNAME)/$(DOCKER_HUB_REPO):latest && docker-compose up -d"

clean:
	@echo "Cleaning up Docker images..."
	docker rmi $(IMAGE_NAME)
	docker rmi $(DOCKER_HUB_USERNAME)/$(DOCKER_HUB_REPO):latest
