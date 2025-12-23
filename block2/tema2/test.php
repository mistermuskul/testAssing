<?php

declare(strict_types=1);

echo "=== Задание 1: Инкапсуляция ===\n";
require_once 'task1/Solution.php';
$account = new Task1\BankAccount(1000);
$account->deposit(500);
echo $account->getBalance() . "\n";
$account->withdraw(300);
echo $account->getBalance() . "\n";
try {
    $account->withdraw(5000);
} catch (\RuntimeException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Задание 2: Наследование ===\n";
require_once 'task2/Solution.php';
$savings = new Task2\SavingsAccount(1000, 5);
$savings->applyInterest();
echo $savings->getBalance() . "\n\n";

echo "=== Задание 3: Полиморфизм (переопределение методов) ===\n";
require_once 'task3/Solution.php';
$credit = new Task3\CreditAccount(1000);
$credit->withdraw(1500);
echo $credit->getBalance() . "\n\n";

echo "=== Задание 4: Полиморфизм через интерфейсы ===\n";
require_once 'task4/Solution.php';
$bank = new Task4\BankAccount(500);
$credit = new Task4\CreditAccount(500);
$bank->pay(200);
echo "Баланс банковского счета: " . $bank->getBalance() . "\n";
$credit->pay(700);
echo "Баланс кредитного счета: " . $credit->getBalance() . "\n";

