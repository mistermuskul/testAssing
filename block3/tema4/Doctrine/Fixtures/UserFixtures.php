<?php

namespace App\Fixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            ['name' => 'Иван', 'email' => 'ivan@example.com', 'password' => password_hash('password1', PASSWORD_BCRYPT), 'role' => 'user'],
            ['name' => 'Мария', 'email' => 'maria@example.com', 'password' => password_hash('password2', PASSWORD_BCRYPT), 'role' => 'user'],
            ['name' => 'Петр', 'email' => 'petr@example.com', 'password' => password_hash('password3', PASSWORD_BCRYPT), 'role' => 'admin'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $user->setRole($userData['role']);
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}

