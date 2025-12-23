<?php

class SchemaManager
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function createEloquentTables()
    {
        $pdo = new PDO(
            "mysql:host={$this->config['host']};dbname={$this->config['dbname']}",
            $this->config['user'],
            $this->config['password']
        );

        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255)
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");
    }
}

