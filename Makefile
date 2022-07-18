DOCKER_COMPOSE=docker-compose --project-name=feedback_test

init:
	make env
	make up
	make install
	make migrate
up:
	${DOCKER_COMPOSE} build app
	${DOCKER_COMPOSE} up -d
env:
	cp .env.example .env
install:
	${DOCKER_COMPOSE} exec app composer install
down:
	${DOCKER_COMPOSE} down --remove-orphans
shell:
	${DOCKER_COMPOSE} exec app php bash
migrate:
	${DOCKER_COMPOSE} exec app php artisan key:generate
	make seed
seed:
	${DOCKER_COMPOSE} exec app php artisan migrate:fresh --seed
test:
	${DOCKER_COMPOSE} exec app php artisan test
npm_install:
	${DOCKER_COMPOSE} run --rm npm install
	make npm_prod
npm_prod:
	${DOCKER_COMPOSE} run --rm npm run prod
npm_watch:
	${DOCKER_COMPOSE} run --rm npm run watch
work:
	${DOCKER_COMPOSE} exec app php artisan queue:work
