MYSQL_USER=root
MYSQL_PASSWORD=root

help:
	@echo ""
	@echo "/---------------/* Achievement Management */------------/";
	@echo ""
	@echo " up		Create and start containers"
	@echo " destroy	Stop and remove containers"
	@echo " status 	Shows the status of the containers"
	@echo " shell		Starting a shell in php container as dev (not sudo)"
	@echo " root-shell	Starting a shell in php container as root (sudo)"
	@echo " setup		Setup application for the first time"
	@echo " mysql		Starting a shell in mysql container"
	@echo " phpunit        Run phpunit tests"
	@echo ""
	@echo "/-----------------------------------------------------------------/";

up:
	docker-compose up -d

destroy:
	docker-compose down

status:
	docker-compose ps

shell:
	docker-compose exec php bash -c "sudo -u dev /bin/bash"

root-shell:
	docker-compose exec php bash

setup:
	docker-compose exec php composer install
	# docker-compose exec php npm install
	docker-compose exec php php artisan storage:link
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan db:seed
	docker-compose exec php php artisan optimize
	sudo chmod -R 777 storage

mysql:
	docker-compose exec mysql mysql -u$(MYSQL_USER) -p$(MYSQL_PASSWORD)

phpunit:
	docker-compose exec php php ./vendor/bin/phpunit

