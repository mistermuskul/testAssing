<?php

declare(strict_types=1);

function filterEvenNumbers(array $numbers): array
{
    return array_values(array_filter($numbers, fn($n) => $n % 2 === 0));
}

