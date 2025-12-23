<?php

class DatabaseManager
{
    private $config;

    public function __construct($config = null)
    {
        $this->config = $config ?? Config::getDbConfig();
    }

    public function ensureDatabaseExists()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->config['host']}",
                $this->config['user'],
                $this->config['password']
            );
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$this->config['dbname']}'");
            if ($stmt->rowCount() == 0) {
                $pdo->exec("CREATE DATABASE {$this->config['dbname']}");
            }
        } catch (PDOException $e) {
        }
    }

    public function getConfig()
    {
        return $this->config;
    }
}

