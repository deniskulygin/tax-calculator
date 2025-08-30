# https://clarkgrubb.com/makefile-style-guide#phony-targets

DOCKER_BUILD_VARS := COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1
DOCKER_BUILD := ${DOCKER_BUILD_VARS} docker build

COMPOSE := $(DOCKER_BUILD_VARS) docker-compose

.env:
	cp .env.dist .env

build:
	${COMPOSE} pull --ignore-pull-failures --include-deps
	${COMPOSE} build

setup: .env build
	${COMPOSE} run --rm php composer install

start:
	${COMPOSE} up -d

stop:
	${COMPOSE} down

destroy: stop
	${COMPOSE} rm --force --stop -v

redis-flushall:
	${COMPOSE} run redis sh -c "redis-cli -h redis flushall"

bash:
	${COMPOSE} run php bash

integration-test-up:
	${COMPOSE} -f docker-compose.test.yml -p taxes_calculator_tests up -d

integration-test-down:
	${COMPOSE} -f docker-compose.test.yml -p taxes_calculator_tests down -v

integration-test-bash: integration-test-up
	docker exec -ti taxes_calculator_test_php bash

integration-test-run: integration-test-up
	docker exec -ti taxes_calculator_test_php bash -c "vendor/bin/codecept run tests/integration"

unit-test-run: integration-test-up
	docker exec -ti taxes_calculator_test_php bash -c "vendor/bin/phpunit"

phpcs: integration-test-up
	docker exec -ti taxes_calculator_test_php bash -c "vendor/bin/phpcs --standard=phpcs.xml.dist"

phpcbf: integration-test-up
	docker exec -ti taxes_calculator_test_php bash -c "vendor/bin/phpcbf --standard=phpcs.xml.dist"

