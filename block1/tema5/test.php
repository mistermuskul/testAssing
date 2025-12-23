<?php

declare(strict_types=1);

require_once 'task1/Solution.php';
require_once 'task2/Solution.php';
require_once 'task3/Solution.php';
require_once 'task4/Solution.php';
require_once 'task5/Solution.php';

echo "=== Задание 1: Аргументы по умолчанию ===\n";
echo greetUser("Иван") . "\n";
echo greetUser("John", "en") . "\n\n";

echo "=== Задание 2: Именованные аргументы ===\n";
echo calculateDiscount(price: 1000) . "\n";
echo calculateDiscount(price: 2000, discount: 20) . "\n\n";

echo "=== Задание 3: Несколько аргументов по умолчанию ===\n";
echo orderPizza() . "\n";
echo orderPizza(size: "large", toppings: ["cheese", "pepperoni"]) . "\n\n";

echo "=== Задание 4: Обязательные и необязательные аргументы ===\n";
echo formatText("hello") . "\n";
echo formatText("hello", true) . "\n\n";

echo "=== Задание 5: Именованные аргументы с разным порядком ===\n";
$pass1 = generatePassword();
echo "Пароль 1 (длина: " . strlen($pass1) . "): {$pass1}\n";
$pass2 = generatePassword(length: 12, includeSpecialChars: true);
echo "Пароль 2 (длина: " . strlen($pass2) . "): {$pass2}\n";

