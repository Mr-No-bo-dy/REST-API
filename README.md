# Articles Catalog API (Laravel)

Цей проєкт є RESTfull API для управління каталогом статтей, розроблений з використанням Laravel. 
API дозволяє створювати, переглядати, оновлювати та видаляти статті. 
Реалізовано принципи чистої архітектури: контролери, сервіси, репозиторії, валідація та API-ресурси.

## Можливості
- CRUD операції для статтей
- Валідація вхідних запитів
- Структуровані JSON-відповіді через API Resources
- Підтримка пагінації та сортування
- Репозиторії для роботи з базою даних
- Сервіси для бізнес-логіки
- Юніт- та інтеграційні тести
- Готовність до розширення (коментарі, авторизація, тощо)

## Технології
- Laravel 10+
- PHP 8.1+
- PHPUnit
- SQLite

## Налаштування .env
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Встановлення
```
git clone https://github.com/Mr-No-bo-dy/REST-API.git

cd REST-API

composer install

cp .env.example .env

php artisan key:generate

touch database/database.sqlite (Linux/MacOS)
New-Item -ItemType File -Path database/database.sqlite (Windows)

php artisan migrate

php artisan serve

```


## API Endpoint-и
| Метод       | Endpoint           | Опис                 |
|-------------| ------------------ | -------------------- |
| GET         | /api/articles      | Отримати всі статті  |
| GET         | /api/articles/{id} | Отримати одну статтю |
| POST        | /api/articles      | Створити статтю      |
| PUT / PATCH | /api/articles/{id} | Оновити статтю       |
| DELETE      | /api/articles/{id} | Видалити статтю      |


## Приклад запиту (POST /api/articles)
```
{
  "title": "Laravel 11 Released",
  "description": "Нові можливості в Laravel 11...",
  "category_id": 2,
  "author": "Mr-No-bo-dy",
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

## Документація API:
Linux / MacOS:
```
http://localhost:8000/api/documentation
```
Windows:
```
http://127.0.0.1:8000/api/documentation
```
