<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseConnection
{
    private static $initialized = false;

    public static function init()
    {
        if (self::$initialized) {
            return;
        }

        $config = Config::getDbConfig();
        
        try {
            $pdo = new PDO(
                "mysql:host={$config['host']}",
                $config['user'],
                $config['password']
            );
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$config['dbname']}'");
            if ($stmt->rowCount() == 0) {
                $pdo->exec("CREATE DATABASE {$config['dbname']}");
            }
        } catch (PDOException $e) {
        }
        
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $config['host'],
            'database' => $config['dbname'],
            'username' => $config['user'],
            'password' => $config['password'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
        
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        
        self::$initialized = true;
    }
}

