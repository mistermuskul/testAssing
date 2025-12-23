<?php

function getStatusMessage(string $status): string
{
    return match ($status) {
        'success' => 'Операция выполнена успешно',
        'error' => 'Произошла ошибка',
        'pending' => 'Операция в ожидании',
        default => 'Неизвестный статус',
    };
}

