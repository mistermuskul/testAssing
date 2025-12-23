<?php

function getUserEmail(object $user): string
{
    return $user->profile?->email ?? 'Email не найден';
}

