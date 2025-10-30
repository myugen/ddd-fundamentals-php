.PHONY: help install build test up-bank up-db down logs run-bank

help:
	@echo "Comandos disponibles:"
	@echo "  make install   - Instalar dependencias PHP"
	@echo "  make build     - Construir imágenes Docker"
	@echo "  make test      - Ejecutar tests"
	@echo "  make up-bank   - Iniciar BankKata (Docker)"
	@echo "  make up-db     - Iniciar MySQL (Docker)"
	@echo "  make run-bank  - Ejecutar BankKata localmente"
	@echo "  make down      - Detener servicios Docker"
	@echo "  make logs      - Ver logs de servicios"

install:
	composer install

build:
	docker-compose build

test:
	docker compose run --build test

up-bank:
	docker-compose up bank-kata

up-db:
	docker-compose up -d mysql

down:
	docker-compose down

logs:
	docker-compose logs -f

run-bank: up-db
	php -S localhost:8000 -t src/BankKata