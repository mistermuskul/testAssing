<?php

require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Database.php';
require_once 'Container.php';
require_once 'interfaces/UserRepositoryInterface.php';
require_once 'repositories/UserRepository.php';
require_once 'services/UserService.php';
require_once 'providers/UserServiceProvider.php';

$db = new Database();
$pdo = $db->connect();

$pdo->exec("DELETE FROM users");
$pdo->exec("INSERT INTO users (name, email) VALUES ('Иван', 'ivan@example.com'), ('Анна', 'anna@example.com')");

echo "=== Задание 1: Регистрация сервиса в DI-контейнере ===\n";
$container = new Container();
$container->bind('PDO', function($container) {
    $db = new Database();
    return $db->connect();
});
$container->bind('UserRepository', function($container) {
    $pdo = $container->get('PDO');
    return new UserRepository($pdo);
});
$container->bind('UserService', function($container) {
    $userRepository = $container->get('UserRepository');
    return new UserService($userRepository);
});
$users = $container->get('UserService')->getUsers();
print_r($users);
echo "\n";

echo "=== Задание 2: Внедрение зависимостей через контейнер ===\n";
$container2 = new Container();
$container2->bind('PDO', function($container) {
    $db = new Database();
    return $db->connect();
});
$container2->bind('UserRepository', function($container) {
    $pdo = $container->get('PDO');
    return new UserRepository($pdo);
});
$container2->bind('UserService', function($container) {
    $userRepository = $container->get('UserRepository');
    return new UserService($userRepository);
});
$service = $container2->get('UserService');
print_r($service->getUsers());
echo "\n";

echo "=== Задание 3: Использование интерфейсов в DI ===\n";
$container3 = new Container();
$container3->bind('PDO', function($container) {
    $db = new Database();
    return $db->connect();
});
$container3->bind('UserRepositoryInterface', function($container) {
    $pdo = $container->get('PDO');
    return new UserRepository($pdo);
});
$container3->bind('UserService', function($container) {
    $userRepository = $container->get('UserRepositoryInterface');
    return new UserService($userRepository);
});
$service = $container3->get('UserService');
print_r($service->getUsers());
echo "\n";

echo "=== Задание 4: Создание сервис-провайдера ===\n";
$container4 = new Container();
$provider = new UserServiceProvider($container4);
$provider->register();
$service = $container4->get('UserService');
print_r($service->getUsers());
echo "\n";

