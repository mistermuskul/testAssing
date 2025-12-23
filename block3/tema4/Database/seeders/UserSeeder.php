<?php

class UserSeeder
{
    public function run()
    {
        $users = [
            ['name' => 'Иван', 'email' => 'ivan@example.com', 'password' => password_hash('password1', PASSWORD_BCRYPT), 'role' => 'user'],
            ['name' => 'Мария', 'email' => 'maria@example.com', 'password' => password_hash('password2', PASSWORD_BCRYPT), 'role' => 'user'],
            ['name' => 'Петр', 'email' => 'petr@example.com', 'password' => password_hash('password3', PASSWORD_BCRYPT), 'role' => 'admin'],
            ['name' => 'Анна', 'email' => 'anna@example.com', 'password' => password_hash('password4', PASSWORD_BCRYPT), 'role' => 'user'],
            ['name' => 'Сергей', 'email' => 'sergey@example.com', 'password' => password_hash('password5', PASSWORD_BCRYPT), 'role' => 'user'],
        ];

        foreach ($users as $user) {
            \Illuminate\Database\Capsule\Manager::table('users')->insert($user);
        }
    }
}
