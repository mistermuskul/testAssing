<?php

function checkDocker() {
    exec('docker --version 2>&1', $output, $returnCode);
    return $returnCode === 0;
}

function checkDockerCompose() {
    exec('docker-compose --version 2>&1', $output, $returnCode);
    if ($returnCode !== 0) {
        exec('docker compose version 2>&1', $output, $returnCode);
    }
    return $returnCode === 0;
}

echo "=== Docker Environment Check ===\n";
if (checkDocker()) {
    echo "✅ Docker is installed\n";
} else {
    echo "❌ Docker is not installed or not in PATH\n";
    exit(1);
}

if (checkDockerCompose()) {
    echo "✅ Docker Compose is installed\n";
} else {
    echo "⚠️  Docker Compose is not installed (task2 will be skipped)\n";
}

$tasks = [
    'task1' => [
        'name' => 'Dockerfile for PHP app',
        'check' => 'Dockerfile',
        'build' => 'docker build -t php-app-task1 .',
        'run' => 'docker run -d -p 8080:80 --name php-app-test-task1 php-app-task1',
        'test_url' => 'http://localhost:8080',
        'cleanup' => 'docker stop php-app-test-task1 && docker rm php-app-test-task1 && docker rmi php-app-task1'
    ],
    'task2' => [
        'name' => 'Docker Compose with MySQL',
        'check' => 'docker-compose.yml',
        'build' => 'docker-compose up -d',
        'test_url' => 'http://localhost:8080',
        'cleanup' => 'docker-compose down -v'
    ]
];

foreach ($tasks as $taskDir => $task) {
    $taskPath = __DIR__ . '/' . $taskDir;
    
    if (!is_dir($taskPath)) {
        echo "\n❌ {$task['name']}: Directory not found\n";
        continue;
    }
    
    echo "\n=== {$task['name']} ===\n";
    
    $checkFile = $taskPath . '/' . $task['check'];
    if (!file_exists($checkFile)) {
        echo "❌ {$task['check']} not found\n";
        continue;
    }
    echo "✅ {$task['check']} found\n";
    
    if (file_exists($taskPath . '/Dockerfile')) {
        echo "✅ Dockerfile found\n";
    } else {
        echo "❌ Dockerfile not found\n";
        continue;
    }
    
    if (file_exists($taskPath . '/src/index.php')) {
        echo "✅ src/index.php found\n";
    } else {
        echo "❌ src/index.php not found\n";
        continue;
    }
    
    $originalDir = getcwd();
    chdir($taskPath);
    
    echo "\nTesting Docker build...\n";
    if ($taskDir === 'task1') {
        exec('docker stop php-app-test-task1 2>&1', $output, $returnCode);
        exec('docker rm php-app-test-task1 2>&1', $output, $returnCode);
        exec('docker rmi php-app-task1 2>&1', $output, $returnCode);
        
        exec($task['build'] . ' 2>&1', $output, $returnCode);
        if ($returnCode === 0) {
            echo "✅ Docker image built successfully\n";
            
            echo "Starting container...\n";
            exec($task['run'] . ' 2>&1', $output, $returnCode);
            if ($returnCode === 0) {
                echo "✅ Container started\n";
                sleep(2);
                
                echo "Testing HTTP connection...\n";
                $ch = curl_init($task['test_url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($httpCode === 200) {
                    echo "✅ Application is accessible at {$task['test_url']}\n";
                } else {
                    echo "⚠️  Application returned HTTP {$httpCode}\n";
                }
                
                echo "Cleaning up...\n";
                exec($task['cleanup'] . ' 2>&1', $output, $returnCode);
            } else {
                echo "❌ Failed to start container\n";
                echo implode("\n", $output) . "\n";
            }
        } else {
            echo "❌ Docker build failed\n";
            echo implode("\n", array_slice($output, -10)) . "\n";
        }
    } else {
        if (!checkDockerCompose()) {
            echo "⚠️  Skipping Docker Compose test (not installed)\n";
            chdir($originalDir);
            continue;
        }
        
        exec('docker-compose down -v 2>&1', $output, $returnCode);
        
        exec($task['build'] . ' 2>&1', $output, $returnCode);
        if ($returnCode === 0) {
            echo "✅ Docker Compose services started\n";
            sleep(5);
            
            echo "Testing HTTP connection...\n";
            $ch = curl_init($task['test_url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200 && strpos($response, 'Connected to MySQL') !== false) {
                echo "✅ Application is accessible and connected to MySQL\n";
            } elseif ($httpCode === 200) {
                echo "✅ Application is accessible at {$task['test_url']}\n";
                echo "⚠️  MySQL connection status unclear\n";
            } else {
                echo "⚠️  Application returned HTTP {$httpCode}\n";
            }
            
            echo "Cleaning up...\n";
            exec($task['cleanup'] . ' 2>&1', $output, $returnCode);
        } else {
            echo "❌ Docker Compose failed\n";
            echo implode("\n", array_slice($output, -10)) . "\n";
        }
    }
    
    chdir($originalDir);
}

echo "\n=== All tasks checked ===\n";
echo "\nManual test commands:\n";
echo "Task 1:\n";
echo "  cd task1\n";
echo "  docker build -t php-app .\n";
echo "  docker run -p 8080:80 php-app\n";
echo "  # Open http://localhost:8080 in browser\n\n";
echo "Task 2:\n";
echo "  cd task2\n";
echo "  docker-compose up -d\n";
echo "  # Open http://localhost:8080 in browser\n";
echo "  docker-compose down -v\n";
