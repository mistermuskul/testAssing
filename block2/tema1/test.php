<?php

declare(strict_types=1);

echo "=== Задание 1: Создание класса и объектов ===\n";
require_once 'task1/Solution.php';
$car = new Task1\Car("Toyota", "Camry", 2020);
echo $car->getCarInfo() . "\n\n";

echo "=== Задание 2: Использование инкапсуляции ===\n";
require_once 'task2/Solution.php';
$car2 = new Task2\Car("Toyota", "Camry", 2020);
$car2->setYear(2022);
echo $car2->getYear() . "\n\n";

echo "=== Задание 3: Наследование классов ===\n";
require_once 'task3/Solution.php';
$tesla = new Task3\ElectricCar("Tesla", "Model S", 2021, 100);
echo $tesla->getBatteryInfo() . "\n\n";

echo "=== Задание 4: Реализация интерфейса ===\n";
require_once 'task4/Solution.php';
$car4 = new Task4\Car("Ford", "Focus", 2019);
echo $car4->move() . "\n";
$bike = new Task4\Bicycle();
echo $bike->move() . "\n\n";

echo "=== Задание 5: Использование трейтов ===\n";
require_once 'task5/Solution.php';
$car5 = new Task5\Car("Toyota", "Camry", 2020);
$car5->log("Запущен двигатель");

