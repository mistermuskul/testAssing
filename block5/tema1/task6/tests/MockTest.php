<?php

require_once __DIR__ . '/../src/UserRepository.php';
require_once __DIR__ . '/../src/UserService.php';

use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    public function testFindUserByEmailIsCalled()
    {
        $mockRepository = \Mockery::mock(UserRepository::class);
        $mockRepository->shouldReceive('findUserByEmail')
            ->once()
            ->with('test@example.com')
            ->andReturn(null);

        $userService = new UserService($mockRepository);
        $userService->getUserByEmail('test@example.com');

        $this->assertTrue(true);
    }
}
