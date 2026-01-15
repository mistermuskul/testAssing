<?php

class UserServiceProvider
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function register()
    {
        $this->container->bind('PDO', function($container) {
            $db = new Database();
            return $db->connect();
        });

        $this->container->bind('UserRepositoryInterface', function($container) {
            $pdo = $container->get('PDO');
            return new UserRepository($pdo);
        });

        $this->container->bind('UserService', function($container) {
            $userRepository = $container->get('UserRepositoryInterface');
            return new UserService($userRepository);
        });
    }
}

