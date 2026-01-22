<?php

$tasks = [
    'task1' => ['name' => 'PHPUnit installation', 'test' => 'vendor/bin/phpunit tests/UserTest.php'],
    'task2' => ['name' => 'Unit test UserCanBeCreated', 'test' => 'vendor/bin/phpunit tests/UserTest.php'],
    'task3' => ['name' => 'Test UserFullName method', 'test' => 'vendor/bin/phpunit tests/UserTest.php'],
    'task4' => ['name' => 'Pest installation', 'test' => 'vendor/bin/pest'],
    'task5' => ['name' => 'API integration test', 'test' => 'vendor/bin/phpunit tests/ApiTest.php'],
    'task6' => ['name' => 'Mock objects', 'test' => 'vendor/bin/phpunit tests/MockTest.php']
];

foreach ($tasks as $taskDir => $task) {
    $taskPath = __DIR__ . '/' . $taskDir;
    
    if (!is_dir($taskPath)) {
        echo "❌ {$task['name']}: Directory not found\n";
        continue;
    }
    
    echo "\n=== {$task['name']} ===\n";
    
    if (!file_exists($taskPath . '/composer.json')) {
        echo "❌ composer.json not found\n";
        continue;
    }
    
    $originalDir = getcwd();
    chdir($taskPath);
    
    if (!is_dir('vendor')) {
        echo "Installing dependencies...\n";
        exec('composer install --no-interaction 2>&1', $output, $returnCode);
        if ($returnCode !== 0) {
            echo "❌ Failed to install dependencies\n";
            chdir($originalDir);
            continue;
        }
    }
    
    echo "Running tests...\n";
    $testCommand = $task['test'];
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $testCommand = 'php ' . $testCommand;
    }
    exec($testCommand . ' 2>&1', $output, $returnCode);
    echo implode("\n", $output);
    
    if ($returnCode === 0) {
        echo "\n✅ {$task['name']}: Tests passed\n";
    } else {
        echo "\n❌ {$task['name']}: Tests failed\n";
    }
    
    chdir($originalDir);
}

echo "\n=== All tasks completed ===\n";
