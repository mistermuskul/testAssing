<?php

class Config
{
    public static function getDbConfig()
    {
        return [
            'host' => 'localhost',
            'dbname' => 'taskassign_migrations_db',
            'user' => 'root',
            'password' => '123'
        ];
    }
}

