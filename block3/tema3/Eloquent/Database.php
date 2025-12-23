<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentDatabase
{
    private $dbManager;
    private $schemaManager;

    public function __construct($dbManager = null, $schemaManager = null)
    {
        $this->dbManager = $dbManager ?? new DatabaseManager();
        $this->schemaManager = $schemaManager ?? new SchemaManager($this->dbManager->getConfig());
    }

    public function init()
    {
        $config = $this->dbManager->getConfig();
        
        $this->dbManager->ensureDatabaseExists();
        $this->schemaManager->createEloquentTables();
        
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
    }
}

