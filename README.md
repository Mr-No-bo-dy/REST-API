# Articles Catalog API (Laravel)

This project is a RESTful API for managing an article catalogue, developed using Laravel.
The API allows you to create, view, update, and delete articles.
Clean architecture principles have been implemented: controllers, services, repositories, validation, and API resources.

## Features
- CRUD operations for articles
- Validation of incoming requests
- Structured JSON responses via API Resources
- Support for pagination and sorting
- Repositories for working with the database
- Services for business logic
- Unit- and feature Tests
- Open for expansion (comments, authorisation, etc.)

## Technologies
- Laravel 11+
- PHP 8.2+
- PHPUnit
- SQLite

## Installation
1.  Clone the repository:
    ```bash
    git clone https://github.com/Mr-No-bo-dy/REST-API.git
    ```

2. Navigate to project's directory:
    ```bash
    cd REST-API
    ```

3.  Install dependencies:
    ```bash
    composer install
    npm install
    ```

4.  Configure your environment:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  Add your API access token in the `.env` file:
    ```
    API_ACCESS_TOKEN=your_token
    ```

6. Create a database
* Linux / MacOS:
    ```bash
    touch database/database.sqlite
    ```
* Windows:
    ```bash
    New-Item -ItemType File -Path database/database.sqlite
    ```

7. Start database migrations:
    ```bash
    php artisan migrate
    ```

8. [Optional] Create test items
    ```bash
    php artisan db:seed
    ```

9. Start the development server:
    ```bash
    php artisan serve
    ```

## API Endpoints
| Method      | Endpoint             | Description         |
|-------------|----------------------|---------------------|
| GET         | /api/categories      | Get all categories  |
| GET         | /api/categories/{id} | Get one category    |
| GET         | /api/articles        | Get all articles    |
| GET         | /api/articles/{id}   | Get one article     |
| POST        | /api/articles        | Create an article   |
| PUT / PATCH | /api/articles/{id}   | Update an article   |
| DELETE      | /api/articles/{id}   | Delete an article   |


## Example request (POST /api/articles)
```
{
  "title": "Laravel 11 Released",
  "description": "Нові можливості в Laravel 11...",
  "category_id": 2,
  "author": "Mr-No-bo-dy",
  "published_at": "2025-05-13T12:00:00"
}
```

## Testing
```
php artisan test
```

## php-cs-fixer
``` 
composer fix
```

## API documentation:
```
http://127.0.0.1:8000/api/documentation
```

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
