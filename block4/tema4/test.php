<?php

echo "=== Задание 1: Настройка очереди в Redis (Laravel-style) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test: php artisan.php queue:work\n";
    echo "In another terminal, add jobs to queue\n\n";
}

echo "=== Задание 2: Запуск очереди в Redis вручную (PHP + Predis) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test:\n";
    echo "  Terminal 1: php redis_consumer.php\n";
    echo "  Terminal 2: php redis_producer.php\n\n";
}

echo "=== Задание 3: Настройка RabbitMQ и отправка сообщения ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test: php rabbitmq_producer.php\n";
    echo "Make sure RabbitMQ is running on localhost:5672\n\n";
}

echo "=== Задание 4: Запуск обработчика очереди RabbitMQ (Consumer) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ Composer dependencies installed\n";
    echo "To test:\n";
    echo "  Terminal 1: php rabbitmq_consumer.php\n";
    echo "  Terminal 2: php rabbitmq_producer.php\n\n";
}

