<?php

declare(strict_types=1);

require_once 'task1/Solution.php';
require_once 'task2/Solution.php';
require_once 'task3/Solution.php';
require_once 'task4/Solution.php';
require_once 'task5/Solution.php';
require_once 'task6/Solution.php';

echo "=== Задание 1: Проверка числа ===\n";
echo checkNumber(10) . "\n";
echo checkNumber(-5) . "\n";
echo checkNumber(0) . "\n\n";

echo "=== Задание 2: Классификация по возрасту ===\n";
echo getAgeCategory(8) . "\n";
echo getAgeCategory(15) . "\n";
echo getAgeCategory(30) . "\n";
echo getAgeCategory(70) . "\n\n";

echo "=== Задание 3: Вывод чисел ===\n";
printNumbers(5);
echo "\n";

echo "=== Задание 4: Факториал числа ===\n";
echo factorial(5) . "\n";
echo factorial(3) . "\n";
echo factorial(1) . "\n";
echo factorial(0) . "\n\n";

echo "=== Задание 5: Обход массива ===\n";
printArrayItems(["apple", "banana", "cherry"]);
echo "\n";

echo "=== Задание 6: Вывод четных чисел ===\n";
printEvenNumbers(10);

