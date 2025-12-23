<?php

require_once 'task1/Solution.php';
require_once 'task2/Solution.php';
require_once 'task3/Solution.php';
require_once 'task4/Solution.php';
require_once 'task5/Solution.php';

echo "=== Задание 1: match expression ===\n";
echo getStatusMessage('success') . "\n";
echo getStatusMessage('error') . "\n";
echo getStatusMessage('pending') . "\n";
echo getStatusMessage('unknown') . "\n\n";

echo "=== Задание 2: named arguments ===\n";
echo calculatePrice(basePrice: 1000, discount: 10, tax: 5) . "\n";
echo calculatePrice(tax: 5, discount: 10, basePrice: 2000) . "\n\n";

echo "=== Задание 3: readonly properties ===\n";
$user = new User(1, 'Иван', 'ivan@example.com');
echo $user->name . "\n";
try {
    $user->name = 'Петр';
} catch (Error $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
echo "\n";

echo "=== Задание 4: Enums ===\n";
echo getDeliveryMessage(OrderStatus::Pending) . "\n";
echo getDeliveryMessage(OrderStatus::Shipped) . "\n";
echo getDeliveryMessage(OrderStatus::Delivered) . "\n\n";

echo "=== Задание 5: null-safe operator ===\n";
$user1 = (object)[
    'profile' => (object)[
        'email' => 'test@example.com'
    ]
];
echo getUserEmail($user1) . "\n";

$user2 = (object)[
    'profile' => null
];
echo getUserEmail($user2) . "\n";

