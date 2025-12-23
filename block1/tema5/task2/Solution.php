<?php

declare(strict_types=1);

function calculateDiscount(float $price, float $discount = 10): float
{
    return $price * (1 - $discount / 100);
}

