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
            
            return "Подключение успешно";
        } catch (PDOException $e) {
            return "Ошибка подключения: " . $e->getMessage();
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
            password VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function getUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        if (!Validator::validateEmail($email)) {
            return ["error" => "Неверный формат email"];
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($name, $email, $password = null)
    {
        if ($password !== null && !Validator::validateEmail($email)) {
            return ["error" => "Неверный формат email"];
        }

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteUser($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
