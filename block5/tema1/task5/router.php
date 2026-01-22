<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/users' && $requestMethod === 'GET') {
    require __DIR__ . '/api.php';
    return true;
}

return false;
