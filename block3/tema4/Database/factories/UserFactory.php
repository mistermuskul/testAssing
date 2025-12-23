<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class UserFactory
{
    public static function create($count = 1)
    {
        $names = ['Алексей', 'Дмитрий', 'Елена', 'Ольга', 'Николай', 'Татьяна', 'Андрей', 'Екатерина', 'Максим', 'Анна'];
        $domains = ['gmail.com', 'yandex.ru', 'mail.ru', 'example.com'];
        $roles = ['user', 'admin', 'moderator'];
        
        $users = [];
        $usedEmails = [];

        for ($i = 0; $i < $count; $i++) {
            $name = $names[array_rand($names)] . ' ' . ($i + 1);
            $domain = $domains[array_rand($domains)];
            $email = strtolower(str_replace(' ', '', $name)) . $i . '@' . $domain;
            
            while (in_array($email, $usedEmails)) {
                $email = strtolower(str_replace(' ', '', $name)) . $i . rand(100, 999) . '@' . $domain;
            }
            $usedEmails[] = $email;
            
            $users[] = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => $roles[array_rand($roles)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        Capsule::table('users')->insert($users);
        return $users;
    }
}

