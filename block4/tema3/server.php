<?php

if (!extension_loaded('swoole')) {
    die("Swoole extension is not installed. Please install it first.\n");
}

$server = new Swoole\Http\Server("0.0.0.0", 9501);

$server->on("start", function ($server) {
    echo "Swoole HTTP server is started at http://0.0.0.0:9501\n";
});

$server->on("request", function ($request, $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello from Swoole HTTP Server!");
});

$server->on("WorkerStart", function ($server, $workerId) {
    if ($workerId === 0) {
        Swoole\Timer::tick(5000, function () {
            echo "Timer tick: " . date('Y-m-d H:i:s') . "\n";
        });
    }
});

$server->start();

