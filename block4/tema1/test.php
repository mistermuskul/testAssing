<?php

require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Database.php';
require_once 'models/User.php';
require_once 'repositories/UserRepository.php';
require_once 'services/UserService.php';
require_once 'controllers/UserController.php';

$db = new Database();
$pdo = $db->connect();

$pdo->exec("DELETE FROM users");
$pdo->exec("INSERT INTO users (name, email) VALUES ('Иван', 'ivan@example.com'), ('Анна', 'anna@example.com')");

echo "=== Задание 1: Создание структуры MVC ===\n";
echo "Структура создана: models/, views/, controllers/, services/, routes/\n\n";

echo "=== Задание 2: Реализация модели (Model) ===\n";
$users = User::getAll();
print_r($users);
echo "\n";

echo "=== Задание 3: Контроллер (Controller) ===\n";
echo "Контроллер UserController создан в controllers/\n";
echo "Проверка: http://localhost/users\n\n";

echo "=== Задание 4: Разделение логики через сервисный слой (Service) ===\n";
$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);
$users = $userService->getUsers();
print_r($users);
echo "\n";

echo "=== Задание 5: Внедрение зависимостей (Dependency Injection) ===\n";
$service = new UserService(new UserRepository($pdo));
print_r($service->getUsers());
echo "\n";

