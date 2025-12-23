<?php

declare(strict_types=1);

require_once 'task1/Solution.php';
require_once 'task2/Solution.php';
require_once 'task3/Solution.php';

echo "=== Задание 1: Фильтрация массива ===\n";
print_r(filterEvenNumbers([1, 2, 3, 4, 5, 6]));
print_r(filterEvenNumbers([11, 15, 21]));
echo "\n";

echo "=== Задание 2: Преобразование массива ===\n";
print_r(squareNumbers([1, 2, 3, 4]));
print_r(squareNumbers([-2, 5, 10]));
echo "\n";

echo "=== Задание 3: Ассоциативные массивы ===\n";
$users = [
    ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
];
print_r(getUserEmails($users));

