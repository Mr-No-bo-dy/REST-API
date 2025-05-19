# News Catalog API (Laravel)

Цей проєкт є RESTfull API для управління каталогом новин, розроблений з використанням Laravel. 
API дозволяє створювати, переглядати, оновлювати та видаляти новини. 
Реалізовано принципи чистої архітектури: контролери, сервіси, репозиторії, валідація та API-ресурси.

## Можливості
- CRUD операції для новин
- Валідація вхідних запитів
- Структуровані JSON-відповіді через API Resources
- Підтримка пагінації та сортування
- Репозиторії для роботи з базою
- Сервіси для бізнес-логіки
- Юніт та інтеграційні тести
- Готовність до розширення (коментарі, авторизація, тощо)

## Технології
- Laravel 10+
- PHP 8.1+
- PHPUnit
- SQLlite

## Налаштування .env
```
DB_CONNECTION=sqlite
DB_DATABASE=${DB_DATABASE_PATH}/database.sqlite
DB_DATABASE_PATH=/absolute/path/to/your/project/database
```

## Встановлення

```
git clone https://github.com/yourname/news-api.git

cd news-api

composer install

cp .env.example .env

php artisan key:generate

touch database/database.sqlite

php artisan migrate

php artisan serve

```


## API Endpoint-и
| Метод  | Endpoint       | Опис                 |
| ------ | -------------- | -------------------- |
| GET    | /api/news      | Отримати всі новини  |
| GET    | /api/news/{id} | Отримати одну новину |
| POST   | /api/news      | Створити новину      |
| PUT    | /api/news/{id} | Оновити новину       |
| DELETE | /api/news/{id} | Видалити новину      |


## Приклад запиту (POST /api/news)

```
{
  "title": "Laravel 11 Released",
  "content": "Нові можливості в Laravel 11...",
  "author": "Olena Kozak",
  "published_at": "2025-05-13T12:00:00"
}

```

## Створення тестових елементів

```
php artisan db:seed
```

## Tестування

```
php artisan test
```
## php-cs-fixer

``` 
composer fix
```
