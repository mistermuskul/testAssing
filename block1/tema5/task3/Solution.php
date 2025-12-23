<?php

declare(strict_types=1);

function orderPizza(string $size = 'medium', string $crust = 'thin', array $toppings = ['cheese']): string
{
    $toppingsStr = implode(', ', $toppings);
    $crustText = $crust === 'thin' ? 'тонком' : 'толстом';
    return "Заказ: {$size} пицца на {$crustText} тесте с {$toppingsStr}";
}

