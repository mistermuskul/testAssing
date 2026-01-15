<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$message = "Task from RabbitMQ producer at " . date('Y-m-d H:i:s');
$msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

$channel->basic_publish($msg, '', 'task_queue');

echo "Message sent to RabbitMQ: {$message}\n";

$channel->close();
$connection->close();

