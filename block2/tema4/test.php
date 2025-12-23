<?php

declare(strict_types=1);

echo "=== Задание 1: Использование namespace в классе ===\n";
require_once 'task1/Solution.php';
$user = new App\Models\User("Иван");
echo $user->getName() . "\n\n";

echo "=== Задание 2: Автозагрузка через Composer ===\n";
require_once 'task2/vendor/autoload.php';
$user2 = new App\Models\User("Анна");
echo $user2->getName() . "\n\n";

echo "=== Задание 3: Использование нескольких пространств имен ===\n";
require_once 'task3/vendor/autoload.php';
$service3 = new App\Services\UserService();
echo $service3->getUserGreeting("Олег") . "\n\n";

echo "=== Задание 4: Использование use для сокращения пути ===\n";
require_once 'task4/vendor/autoload.php';
$service4 = new App\Services\UserService();
echo $service4->getUserGreeting("Мария") . "\n\n";

echo "=== Задание 5: Автозагрузка интерфейсов и трейтов ===\n";
require_once 'task5/vendor/autoload.php';
$order = new App\Models\Order();
$order->log("Заказ создан");

