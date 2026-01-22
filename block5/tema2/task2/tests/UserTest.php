<?php

require_once __DIR__ . '/../src/User.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCanBeCreated()
    {
        $user = new User('Иван', 'Иванов', 'ivan@example.com');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Иван', $user->getFirstName());
        $this->assertEquals('Иванов', $user->getLastName());
        $this->assertEquals('ivan@example.com', $user->getEmail());
    }

    public function testUserFullName()
    {
        $user = new User('Иван', 'Иванов', 'ivan@example.com');
        $this->assertEquals('Иван Иванов', $user->getFullName());
    }
}
