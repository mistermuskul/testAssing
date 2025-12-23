<?php

declare(strict_types=1);

function checkNumber(int|float $number): string
{
    if ($number > 0) {
        return 'Положительное';
    } elseif ($number < 0) {
        return 'Отрицательное';
    } else {
        return 'Ноль';
    }
}

