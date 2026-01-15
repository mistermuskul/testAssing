<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/QueueJob.php';
require_once __DIR__ . '/RedisQueue.php';

$queue = new RedisQueue('default');

$message = "Laravel-style job at " . date('Y-m-d H:i:s');
$job = new QueueJob($message);

$queue->push($job);
echo "Job dispatched to queue: {$message}\n";

