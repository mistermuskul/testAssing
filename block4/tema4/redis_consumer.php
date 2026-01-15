<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/QueueJob.php';
require_once __DIR__ . '/RedisQueue.php';

$queue = new RedisQueue('task_queue');
$queue->work();

