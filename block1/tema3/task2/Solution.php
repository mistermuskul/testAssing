<?php

declare(strict_types=1);

function squareNumbers(array $numbers): array
{
    return array_map(fn($n) => $n * $n, $numbers);
}

