cli:
	docker-compose exec fpm bash

up:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

reboot:
	docker-compose restart

install:	
	docker-compose run --rm fpm composer install
