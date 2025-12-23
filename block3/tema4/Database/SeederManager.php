<?php

class SeederManager
{
    private $seedersPath;

    public function __construct()
    {
        $this->seedersPath = __DIR__ . '/seeders';
        if (!file_exists($this->seedersPath)) {
            mkdir($this->seedersPath, 0777, true);
        }
    }

    public function createSeeder($name)
    {
        $fileName = "{$name}.php";
        $filePath = $this->seedersPath . '/' . $fileName;
        
        $content = "<?php

class {$name}
{
    public function run()
    {
        // TODO: Add seeder code here
    }
}
";
        
        file_put_contents($filePath, $content);
        return $filePath;
    }

    public function runSeeder($className)
    {
        $file = $this->seedersPath . '/' . $className . '.php';
        if (!file_exists($file)) {
            echo "Seeder {$className} not found.\n";
            return;
        }
        
        require_once $file;
        $instance = new $className();
        $instance->run();
        echo "Seeder {$className} executed.\n";
    }

    public function runAll()
    {
        $files = glob($this->seedersPath . '/*.php');
        foreach ($files as $file) {
            $className = basename($file, '.php');
            require_once $file;
            $instance = new $className();
            $instance->run();
        }
        echo "All seeders executed.\n";
    }
}

