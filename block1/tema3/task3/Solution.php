<?php

declare(strict_types=1);

function getUserEmails(array $users): array
{
    return array_column($users, 'email');
}

