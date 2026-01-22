<?php

$tasks = [
    'task1' => ['name' => 'GitHub Actions CI/CD', 'check' => '.github/workflows/ci.yml'],
    'task2' => ['name' => 'GitHub Actions with tests', 'check' => '.github/workflows/ci.yml'],
    'task3' => ['name' => 'GitLab CI', 'check' => '.gitlab-ci.yml'],
    'task4' => ['name' => 'GitHub Actions deployment', 'check' => '.github/workflows/deploy.yml']
];

foreach ($tasks as $taskDir => $task) {
    $taskPath = __DIR__ . '/' . $taskDir;
    
    if (!is_dir($taskPath)) {
        echo "❌ {$task['name']}: Directory not found\n";
        continue;
    }
    
    echo "\n=== {$task['name']} ===\n";
    
    $checkFile = $taskPath . '/' . $task['check'];
    if (file_exists($checkFile)) {
        echo "✅ {$task['check']} found\n";
    } else {
        echo "❌ {$task['check']} not found\n";
    }
    
    if (file_exists($taskPath . '/composer.json')) {
        echo "✅ composer.json found\n";
    } else {
        echo "❌ composer.json not found\n";
    }
    
    if (file_exists($taskPath . '/phpunit.xml')) {
        echo "✅ phpunit.xml found\n";
    } else {
        echo "❌ phpunit.xml not found\n";
    }
}

echo "\n=== All tasks checked ===\n";
