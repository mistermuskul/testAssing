<?php

declare(strict_types=1);

function calculateTax(float $price, float $tax): float
{
    return round($price * (1 + $tax), 2);
}

