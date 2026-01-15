### Block 1

**Тема 1:**
```bash
cd block1/tema1
php test.php
```

**Тема 2:**
```bash
cd block1/tema2
php test.php
```

**Тема 3:**
```bash
cd block1/tema3
php test.php
```

**Тема 4:**
```bash
cd block1/tema4
php test.php
```

**Тема 5:**
```bash
cd block1/tema5
php test.php
```

### Block 2

**Тема 1:**
```bash
cd block2/tema1
php test.php
```

**Тема 2:**
```bash
cd block2/tema2
php test.php
```

**Тема 3:**
```bash
cd block2/tema3
php test.php
```

**Тема 4:**
```bash
cd block2/tema4
php test.php
```

### Block 3

**Тема 1-2:**
```bash
cd block3/tema1_tema2
php test.php
```

**Тема 3:**
```bash
cd block3/tema3
composer install
php test.php
```

**Тема 4:**
```bash
cd block3/tema4
composer install
php test.php
```

### Block 4

**Тема 1:**
```bash
cd block4/tema1
php test.php
```

Для проверки через браузер:
```bash
http://localhost/users
```

**Тема 2:**
```bash
cd block4/tema2
php test.php
```

**Тема 3:**
```bash
cd block4/tema3
composer install
php test.php
```

Для задания 1-2 (Swoole):
```bash
php server.php
curl http://localhost:9501
```

Для задания 3 (ReactPHP клиент):
```bash
php client.php
```

Для задания 4 (ReactPHP параллельные задачи):
```bash
php parallel.php
```

**Тема 4:**
```bash
cd block4/tema4
composer install
php test.php
```

Для задания 1 (Laravel-style очередь):
```bash
php artisan.php queue:work
php queue_dispatch.php
```

Для задания 2 (Redis очередь вручную):
```bash
php redis_consumer.php
php redis_producer.php
```

Для задания 3 (RabbitMQ Producer):
```bash
php rabbitmq_producer.php
```

Для задания 4 (RabbitMQ Consumer):
```bash
php rabbitmq_consumer.php
php rabbitmq_producer.php
```

**Тема 5:**
```bash
cd block4/tema5
composer install
php test.php
```

Для запуска сервера (встроенный PHP сервер):
```bash
php -S localhost:8000 api.php
```

Или через Apache/Nginx (настроить виртуальный хост на папку tema5).

Для задания 1 (REST API GET):
```bash
curl -X GET http://localhost:8000/api/users
```

Для задания 2 (REST API POST):
```bash
curl -X POST -H "Content-Type: application/json" -d "{\"name\": \"Иван\"}" http://localhost:8000/api/users
```

Для задания 3 (REST API PUT):
```bash
curl -X PUT -H "Content-Type: application/json" -d "{\"name\": \"Алексей\"}" http://localhost:8000/api/users/1
```

Для задания 4 (REST API DELETE):
```bash
curl -X DELETE http://localhost:8000/api/users/1
```

Для задания 5 (GraphQL Query users):
```bash
curl -X POST -H "Content-Type: application/json" -d "{\"query\": \"{ users { id name } }\"}" http://localhost:8000/graphql
```

Для задания 6 (GraphQL Query getUser):
```bash
curl -X POST -H "Content-Type: application/json" -d "{\"query\": \"{ getUser(id: 1) { name } }\"}" http://localhost:8000/graphql
```

Для задания 7 (GraphQL Mutation createUser):
```bash
curl -X POST -H "Content-Type: application/json" -d "{\"query\": \"mutation { createUser(name: \\\"Мария\\\") { id name } }\"}" http://localhost:8000/graphql
```

## База данных

Для блоков 3 и 4 требуется MySQL:
- **Хост:** `localhost`
- **Пользователь:** `root`
- **Пароль:** `123`
- **БД:** создается автоматически

## Структура проекта


