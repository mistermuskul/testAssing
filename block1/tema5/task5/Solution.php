<?php

declare(strict_types=1);

function generatePassword(int $length = 8, bool $includeNumbers = true, bool $includeSpecialChars = false): string
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $special = '!@#$%^&*';
    
    $pool = $chars;
    if ($includeNumbers) {
        $pool .= $numbers;
    }
    if ($includeSpecialChars) {
        $pool .= $special;
    }
    
    $password = '';
    $poolLength = strlen($pool);
    for ($i = 0; $i < $length; $i++) {
        $password .= $pool[random_int(0, $poolLength - 1)];
    }
    
    return $password;
}

