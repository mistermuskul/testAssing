<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/QueueJob.php';
require_once __DIR__ . '/RedisQueue.php';

$queue = new RedisQueue('task_queue');

$message = "Task from Redis producer at " . date('Y-m-d H:i:s');
$job = new QueueJob($message);

$queue->push($job);
echo "Message added to Redis queue: {$message}\n";

