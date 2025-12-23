<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\SchemaTool;

class DoctrineDatabase
{
    private $dbManager;
    private $entityManager;

    public function __construct($dbManager = null)
    {
        $this->dbManager = $dbManager ?? new DatabaseManager();
    }

    public function init(): EntityManager
    {
        $config = $this->dbManager->getConfig();
        
        $this->dbManager->ensureDatabaseExists();
        
        $paths = [__DIR__ . '/Entity'];
        $isDevMode = false;
        
        $dbParams = [
            'driver' => 'pdo_mysql',
            'host' => $config['host'],
            'dbname' => $config['dbname'],
            'user' => $config['user'],
            'password' => $config['password'],
        ];
        
        $configDoctrine = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $connection = DriverManager::getConnection($dbParams, $configDoctrine);
        $this->entityManager = new EntityManager($connection, $configDoctrine);
        
        return $this->entityManager;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}

