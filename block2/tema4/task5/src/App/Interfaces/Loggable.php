<?php

declare(strict_types=1);

namespace App\Interfaces;

interface Loggable
{
    public function log(string $message): void;
}

