<?php

require_once __DIR__ . '/vendor/autoload.php';

use React\Http\Browser;
use React\EventLoop\Loop;

$loop = Loop::get();
$client = new Browser($loop);

echo "Starting parallel async requests...\n";

$promises = [];

for ($i = 1; $i <= 3; $i++) {
    $promises[] = $client->get("https://jsonplaceholder.typicode.com/posts/{$i}")
        ->then(function ($response) use ($i) {
            return $response->getBody();
        })
        ->then(function ($body) use ($i) {
            $data = json_decode($body, true);
            echo "Request {$i} completed: " . $data['title'] . "\n";
            return $data;
        })
        ->catch(function ($error) use ($i) {
            echo "Request {$i} failed: " . $error->getMessage() . "\n";
            return null;
        });
}

echo "All requests sent, waiting for responses...\n";

React\Promise\all($promises)->then(function ($results) {
    echo "All requests completed!\n";
    Loop::stop();
})->catch(function ($error) {
    echo "Error: " . $error->getMessage() . "\n";
    Loop::stop();
});

$loop->run();

