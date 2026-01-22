<?php

class UserService
{
    private $users = [];

    public function __construct()
    {
        $this->users = [
            new User(1, 'Иван', 'ivan@example.com'),
            new User(2, 'Анна', 'anna@example.com')
        ];
    }

    public function getAllUsers()
    {
        return $this->users;
    }
}
