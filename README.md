# Quizm quiz backend
**Микросервис, отвечающий за работу с квизами, явяется частью сайта для прохождения квизов Quizm**


## Архитектуры и зависимости

### Используемые технологии

- php 3.8
- Laravel 12.x
- php-cs-fixer
- phpstan

### Взаимодействие с другими микросервисами

- [Микросервис для работы с пользователями](https://github.com/Mantix0/quizm-user-backend)

## Запуск 

### Запуск через docker

Указать переменные среды и поднять контейнер
```
docker-compose up
```

### Альтернативный запуск без docker
```
composer run dev
```

### Переменные среды
```dotenv
DB_HOST # Хост базы данных (указать db при запуске через docker)
DB_PORT # Порт базы данных
DB_DATABASE # Название базы данных
DB_USERNAME # Пользователь базы данных
DB_PASSWORD # Пароль базы данных
SECRET_KEY # Ключ для шифрования
ALGORITHM # Алгоритм шифрования
AUTH_URL # Адрес микросервиса для пользователей
```
## API документация
<details>
<summary><strong>V1</strong></summary>

### /quizzes

#### POST
##### Summary:

Creates new quiz.

##### Responses

| Code | Description |
| ---- | ----------- |
| 201 | Successful operation |

### /quizzes/{id}

#### GET
##### Summary:

Gets quiz by id.

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| id | path |  | Yes | integer |

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Successful operation |
| 404 | Not found |

### /quizzes/{id}/questions

#### GET
##### Summary:

Gets questions from quiz.

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| id | path |  | Yes | integer |

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Successful operation |
| 404 | Not found |

### /quizzes/categories

#### GET
##### Summary:

Gets all existing categories

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Successful operation |

### /quizzes:check_answer

#### POST
##### Summary:

Checks inputted answer.

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Returns correct answer |
| 404 | Answer not found |

### /quizzes:search

#### POST
##### Summary:

Searches quizzes by words in title.

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Returns quizzes |

### /quizzes/by-category/{category_id}

#### GET
##### Summary:

Returns quizzes by given category

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| category_id | path |  | Yes | integer |

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Successful operation |
| 404 | Not found |

### /quizzes:random-quizzes

#### GET
##### Summary:

Gets random quizzes

##### Responses

| Code | Description |
| ---- | ----------- |
| 200 | Successful operation |

</details>


## Тестирование

```
php artisan test
```

## Контактная информация
- Telegram : @frogen436