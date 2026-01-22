<?php

test('user can be created', function () {
    $user = new User('Иван', 'Иванов', 'ivan@example.com');
    expect($user)->toBeInstanceOf(User::class);
});
