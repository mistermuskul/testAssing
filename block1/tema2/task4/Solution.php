<?php

declare(strict_types=1);

function getNamesLength(array $names): array
{
    return array_map('strlen', $names);
}

