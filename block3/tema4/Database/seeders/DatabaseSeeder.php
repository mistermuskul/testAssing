<?php

class DatabaseSeeder
{
    public function run()
    {
        require_once __DIR__ . '/../factories/UserFactory.php';
        UserFactory::create(10);
    }
}
