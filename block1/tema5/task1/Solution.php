<?php

declare(strict_types=1);

function greetUser(string $name, string $lang = 'ru'): string
{
    return match ($lang) {
        'ru' => "Привет, {$name}!",
        'en' => "Hello, {$name}!",
        default => "Hello, {$name}!",
    };
}

