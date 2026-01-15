<?php

require_once __DIR__ . '/vendor/autoload.php';

use React\Http\Browser;
use React\EventLoop\Loop;

$loop = Loop::get();
$client = new Browser($loop);

echo "Starting async HTTP request...\n";

$client->get('https://jsonplaceholder.typicode.com/posts/1')
    ->then(function ($response) {
        echo "Response received:\n";
        return $response->getBody();
    })
    ->then(function ($body) {
        echo $body . "\n";
        Loop::stop();
    })
    ->catch(function ($error) {
        echo "Error: " . $error->getMessage() . "\n";
        Loop::stop();
    });

echo "Request sent, waiting for response...\n";

$loop->run();

