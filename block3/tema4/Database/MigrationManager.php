<?php

class MigrationManager
{
    private $migrationsPath;
    private $migrationsTable = 'migrations';

    public function __construct()
    {
        $this->migrationsPath = __DIR__ . '/migrations';
        if (!file_exists($this->migrationsPath)) {
            mkdir($this->migrationsPath, 0777, true);
        }
        $this->ensureMigrationsTable();
    }

    private function ensureMigrationsTable()
    {
        DatabaseConnection::init();
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
        
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $pdo->exec("CREATE TABLE IF NOT EXISTS {$this->migrationsTable} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL
        )");
    }

    public function createMigration($name)
    {
        $timestamp = date('Y_m_d_His');
        $fileName = "{$timestamp}_{$name}.php";
        $filePath = $this->migrationsPath . '/' . $fileName;
        
        $className = $this->getClassName($name);
        $content = "<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class {$className}
{
    public function up()
    {
        // TODO: Add migration code here
    }

    public function down()
    {
        // TODO: Add rollback code here
    }
}
";
        
        file_put_contents($filePath, $content);
        return $filePath;
    }

    private function getClassName($name)
    {
        $parts = explode('_', $name);
        $className = '';
        foreach ($parts as $part) {
            $className .= ucfirst($part);
        }
        return $className;
    }

    public function migrate()
    {
        DatabaseConnection::init();
        $migrations = $this->getPendingMigrations();
        
        if (empty($migrations)) {
            return "Nothing to migrate.";
        }

        $batch = $this->getNextBatchNumber();
        
        foreach ($migrations as $migration) {
            require_once $migration['file'];
            $className = $migration['class'];
            $instance = new $className();
            $instance->up();
            
            $this->recordMigration($migration['name'], $batch);
        }
        
        return "Migrated: " . count($migrations) . " migration(s).";
    }

    public function rollback()
    {
        DatabaseConnection::init();
        $migrations = $this->getLastBatchMigrations();
        
        if (empty($migrations)) {
            return "Nothing to rollback.";
        }

        foreach ($migrations as $migration) {
            require_once $migration['file'];
            $className = $migration['class'];
            $instance = new $className();
            $instance->down();
            
            $this->removeMigration($migration['name']);
        }
        
        return "Rolled back: " . count($migrations) . " migration(s).";
    }

    private function getPendingMigrations()
    {
        $config = Config::getDbConfig();
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $executed = [];
        $stmt = $pdo->query("SELECT migration FROM {$this->migrationsTable}");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $executed[] = $row['migration'];
        }
        
        $pending = [];
        $files = glob($this->migrationsPath . '/*.php');
        
        foreach ($files as $file) {
            $name = basename($file, '.php');
            if (!in_array($name, $executed)) {
                $content = file_get_contents($file);
                if (preg_match('/class\s+(\w+)/', $content, $matches)) {
                    $className = $matches[1];
                } else {
                    $parts = explode('_', $name);
                    $className = '';
                    foreach ($parts as $part) {
                        $className .= ucfirst($part);
                    }
                }
                
                $pending[] = [
                    'name' => $name,
                    'file' => $file,
                    'class' => $className
                ];
            }
        }
        
        usort($pending, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        
        return $pending;
    }

    private function getLastBatchMigrations()
    {
        $config = Config::getDbConfig();
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $maxBatch = $pdo->query("SELECT MAX(batch) as max_batch FROM {$this->migrationsTable}")->fetch(PDO::FETCH_ASSOC)['max_batch'];
        
        if (!$maxBatch) {
            return [];
        }
        
        $stmt = $pdo->prepare("SELECT migration FROM {$this->migrationsTable} WHERE batch = ? ORDER BY id DESC");
        $stmt->execute([$maxBatch]);
        
        $migrations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $file = $this->migrationsPath . '/' . $row['migration'] . '.php';
            if (file_exists($file)) {
                $content = file_get_contents($file);
                if (preg_match('/class\s+(\w+)/', $content, $matches)) {
                    $className = $matches[1];
                } else {
                    $parts = explode('_', $row['migration']);
                    $className = '';
                    foreach ($parts as $part) {
                        $className .= ucfirst($part);
                    }
                }
                
                $migrations[] = [
                    'name' => $row['migration'],
                    'file' => $file,
                    'class' => $className
                ];
            }
        }
        
        return array_reverse($migrations);
    }

    private function getNextBatchNumber()
    {
        $config = Config::getDbConfig();
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $result = $pdo->query("SELECT MAX(batch) as max_batch FROM {$this->migrationsTable}")->fetch(PDO::FETCH_ASSOC);
        return ($result['max_batch'] ?? 0) + 1;
    }

    private function recordMigration($name, $batch)
    {
        $config = Config::getDbConfig();
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $stmt = $pdo->prepare("INSERT INTO {$this->migrationsTable} (migration, batch) VALUES (?, ?)");
        $stmt->execute([$name, $batch]);
    }

    private function removeMigration($name)
    {
        $config = Config::getDbConfig();
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        
        $stmt = $pdo->prepare("DELETE FROM {$this->migrationsTable} WHERE migration = ?");
        $stmt->execute([$name]);
    }
}

