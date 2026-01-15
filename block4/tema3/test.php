<?php

echo "=== Задание 1: Запуск асинхронного HTTP-сервера (Swoole) ===\n";
if (!extension_loaded('swoole')) {
    echo "⚠ Swoole extension is not installed.\n";
    echo "To test: Install Swoole extension and run: php server.php\n";
    echo "Then test with: curl http://localhost:9501\n\n";
} else {
    echo "✅ Swoole extension is installed\n";
    echo "To test: Run 'php server.php' in one terminal\n";
    echo "Then in another terminal: curl http://localhost:9501\n\n";
}

echo "=== Задание 2: Асинхронный таймер в Swoole ===\n";
if (!extension_loaded('swoole')) {
    echo "⚠ Swoole extension is not installed.\n";
    echo "To test: Install Swoole extension and run: php server.php\n";
    echo "You should see messages every 5 seconds\n\n";
} else {
    echo "✅ Swoole extension is installed\n";
    echo "To test: Run 'php server.php'\n";
    echo "You should see timer messages every 5 seconds\n\n";
}

echo "=== Задание 3: Асинхронный клиент для HTTP-запросов (ReactPHP) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test: php client.php\n\n";
}

echo "=== Задание 4: Запуск нескольких асинхронных задач (ReactPHP) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test: php parallel.php\n\n";
}

