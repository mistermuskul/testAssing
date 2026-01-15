<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/QueueJob.php';
require_once __DIR__ . '/RedisQueue.php';

if ($argc < 2) {
    echo "Usage: php artisan.php queue:work\n";
    exit(1);
}

$command = $argv[1];

if ($command === 'queue:work') {
    $queue = new RedisQueue('default');
    echo "Laravel-style queue worker started...\n";
    $queue->work();
} else {
    echo "Unknown command: {$command}\n";
    exit(1);
}

