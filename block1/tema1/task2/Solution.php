<?php

function calculatePrice(float $basePrice, float $discount, float $tax): float
{
    $priceAfterDiscount = $basePrice * (1 - $discount / 100);
    return $priceAfterDiscount * (1 + $tax / 100);
}

