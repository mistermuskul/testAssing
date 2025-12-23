<?php

declare(strict_types=1);

echo "=== Задание 1: Абстрактный класс и его наследование ===\n";
require_once 'task1/Solution.php';
$rect = new Task1\Rectangle(10, 5);
echo $rect->getArea() . "\n";
$circle = new Task1\Circle(7);
echo $circle->getArea() . "\n\n";

echo "=== Задание 2: Использование интерфейса ===\n";
require_once 'task2/Solution.php';
$rect2 = new Task2\Rectangle(10, 5);
$rect2->draw();
$circle2 = new Task2\Circle(7);
$circle2->draw();
echo "\n";

echo "=== Задание 3: Полиморфизм с интерфейсами ===\n";
require_once 'task3/Solution.php';
Task3\renderShape(new Task3\Rectangle(5, 5));
Task3\renderShape(new Task3\Circle(3));
echo "\n";

echo "=== Задание 4: Абстрактные классы vs интерфейсы ===\n";
require_once 'task4/Solution.php';
$car = new Task4\Car();
$car->move();
$car->refuel();
$bike = new Task4\Bike();
$bike->move();

