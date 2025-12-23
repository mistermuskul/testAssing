<?php

declare(strict_types=1);

function formatText(string $text, bool $uppercase = false): string
{
    return $uppercase ? strtoupper($text) : $text;
}

