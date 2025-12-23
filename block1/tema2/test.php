<?php

declare(strict_types=1);

require_once 'task1/Solution.php';
require_once 'task2/Solution.php';
require_once 'task3/Solution.php';
require_once 'task4/Solution.php';
require_once 'task5/Solution.php';

echo "=== Задание 1: Строгая типизация ===\n";
echo multiply(3, 2) . "\n";
echo multiply(3.5, 2) . "\n";
try {
    multiply('3', 2);
} catch (TypeError $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Задание 2: Работа с bool ===\n";
var_export(isAdult(20));
echo "\n";
var_export(isAdult(17));
echo "\n";
try {
    isAdult('20');
} catch (TypeError $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Задание 3: float и округление ===\n";
echo calculateTax(100, 0.2) . "\n";
echo calculateTax(50, 0.15) . "\n";
echo calculateTax(99.99, 0.05) . "\n\n";

echo "=== Задание 4: array и строгая типизация ===\n";
print_r(getNamesLength(["Alice", "Bob", "Charlie"]));
try {
    getNamesLength([123, "Bob", "Charlie"]);
} catch (TypeError $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Задание 5: union types ===\n";
echo formatValue(100) . "\n";
echo formatValue(99.99) . "\n";
echo formatValue("hello") . "\n";
try {
    formatValue(true);
} catch (TypeError $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}

