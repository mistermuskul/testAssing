<?php

declare(strict_types=1);

function getAgeCategory(int $age): string
{
    return match (true) {
        $age >= 0 && $age <= 12 => 'Ребенок',
        $age >= 13 && $age <= 17 => 'Подросток',
        $age >= 18 && $age <= 64 => 'Взрослый',
        $age >= 65 => 'Пожилой',
        default => 'Неизвестная категория',
    };
}

