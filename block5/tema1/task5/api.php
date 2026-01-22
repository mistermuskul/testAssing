<?php

require_once __DIR__ . '/src/User.php';
require_once __DIR__ . '/src/UserService.php';

if (!headers_sent()) {
    header('Content-Type: application/json');
}

$userService = new UserService();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/users' && $method === 'GET') {
    $users = $userService->getAllUsers();
    $result = array_map(function($user) {
        return $user->toArray();
    }, $users);
    echo json_encode($result);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);
