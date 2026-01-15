<?php

class Database
{
    private $pdo;
    private $config;

    public function __construct($config = null)
    {
        $this->config = $config ?? Config::getDbConfig();
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->config['host']}",
                $this->config['user'],
                $this->config['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->ensureDatabaseExists();
            $this->pdo->exec("USE {$this->config['dbname']}");
            $this->createTableIfNotExists();
            
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception("Ошибка подключения: " . $e->getMessage());
        }
    }

    private function ensureDatabaseExists()
    {
        $stmt = $this->pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$this->config['dbname']}'");
        if ($stmt->rowCount() == 0) {
            $this->pdo->exec("CREATE DATABASE {$this->config['dbname']}");
        }
    }

    private function createTableIfNotExists()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function getPdo()
    {
        if ($this->pdo === null) {
            $this->connect();
        }
        return $this->pdo;
    }
}

