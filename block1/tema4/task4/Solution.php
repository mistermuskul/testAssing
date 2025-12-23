<?php

declare(strict_types=1);

function factorial(int $n): int
{
    if ($n <= 1) {
        return 1;
    }
    
    $result = 1;
    $i = 1;
    while ($i <= $n) {
        $result *= $i;
        $i++;
    }
    
    return $result;
}

