<?php

require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/UserService.php';

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function testUserApiReturnsUsers()
    {
        $_SERVER['REQUEST_URI'] = '/users';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $userService = new UserService();
        $users = $userService->getAllUsers();
        $result = array_map(function($user) {
            return $user->toArray();
        }, $users);
        $output = json_encode($result);

        $data = json_decode($output, true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);
    }
}
