# Книжный магазин

## Пример работы интернет магазина

### Функционал

- Получение товара;
- Наполение корзины;
- Оформление заказа;

### Технологический стэк

- php 8.1
- postgres 13
- symfony 5.4
- rabbitmq

### Install

1. Запуск
```bash
docker-compose up
```
2. Зайти в контейнер
```bash
docker exec -it app /bin/bash
```
3. Установить зависимости
```bash
composer ins
```
4. Накатить миграции
```bash
php bin/console doctrine:migrations:migrate
```
5. Накатить фикстуры
```bash
php bin/console doctrine:fixtures:load
```
6. Зайти в swagger по адресу http://127.0.0.1/api/doc

### Тесты

1. Зайти в контейнер
```bash
docker exec -it app /bin/bash
```
2. Накатить миграции (первый запуск)
```bash
php bin/console doctrine:migrations:migrate --env=test
```
3. Накатить фикстуры (первый запуск)
```bash
php bin/console doctrine:fixtures:load --env=test
```
4. Запустить unit тесты
```bash
make test
```

### PHPSTAN

1. Зайти в контейнер
```bash
docker exec -it app /bin/bash
```
2. Запустить phpstan
```bash
make phpstan
```

### PHPMD

1. Зайти в контейнер
```bash
docker exec -it app /bin/bash
```
2. Запустить phpstan
```bash
make phpmd
```