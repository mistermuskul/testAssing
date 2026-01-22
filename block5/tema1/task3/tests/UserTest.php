<?php

require_once __DIR__ . '/../src/User.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCanBeCreated()
    {
        $user = new User('Иван', 'Иванов', 'ivan@example.com');
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserFullName()
    {
        $user = new User('Иван', 'Иванов', 'ivan@example.com');
        $this->assertEquals('Иван Иванов', $user->getFullName());
    }
}
