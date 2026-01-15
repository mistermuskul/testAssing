<?php

require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Database.php';
require_once 'models/User.php';
require_once 'repositories/UserRepository.php';
require_once 'services/UserService.php';
require_once 'controllers/UserController.php';
require_once 'routes/Router.php';

$db = new Database();
$pdo = $db->connect();

$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
if ($count == 0) {
    $pdo->exec("INSERT INTO users (name, email) VALUES ('Иван', 'ivan@example.com'), ('Анна', 'anna@example.com')");
}

$router = new Router();
$router->addRoute('/users', 'UserController', 'index');
$router->addRoute('/', 'UserController', 'index');

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);

