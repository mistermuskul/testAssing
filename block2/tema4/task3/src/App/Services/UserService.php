<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserGreeting(string $name): string
    {
        $user = new User($name);
        return "Привет, {$user->getName()}!";
    }
}

