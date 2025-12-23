<?php

declare(strict_types=1);

function printEvenNumbers(int $n): void
{
    $i = 1;
    while ($i <= $n) {
        if ($i % 2 !== 0) {
            $i++;
            continue;
        }
        echo $i . "\n";
        $i++;
    }
}

