<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\SchemaTool;

class DoctrineDatabase
{
    private $dbManager;
    private $schemaTool;

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
        $entityManager = new EntityManager($connection, $configDoctrine);
        
        $this->createTablesIfNotExist($entityManager);
        
        return $entityManager;
    }

    private function createTablesIfNotExist(EntityManager $entityManager)
    {
        $this->schemaTool = new SchemaTool($entityManager);
        $classes = [
            $entityManager->getClassMetadata(\App\Entity\User::class),
            $entityManager->getClassMetadata(\App\Entity\Post::class),
        ];
        
        try {
            $this->schemaTool->createSchema($classes);
        } catch (\Exception $e) {
        }
    }
}

