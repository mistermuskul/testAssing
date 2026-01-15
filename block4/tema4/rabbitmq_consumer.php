<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$logFile = __DIR__ . '/rabbitmq.log';

$callback = function ($msg) use ($logFile) {
    $message = $msg->body;
    $logMessage = date('Y-m-d H:i:s') . " - " . $message . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
    echo "Message received and logged: {$message}\n";
    $msg->ack();
};

$channel->basic_qos(0, 1, false);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

echo "RabbitMQ consumer started. Waiting for messages...\n";

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

