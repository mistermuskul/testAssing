<?php

require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once 'repositories/UserRepository.php';
require_once 'services/UserService.php';
require_once 'graphql/resolvers.php';
require_once 'graphql/schema.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

$db = new Database();
$pdo = $db->connect();

$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
if ($count == 0) {
    $pdo->exec("INSERT INTO users (name, email) VALUES ('Иван', 'ivan@example.com'), ('Анна', 'anna@example.com')");
}

$userRepository = new UserRepository($pdo);
$userService = new UserService($userRepository);
$resolvers = new UserResolvers($userService);
$schema = buildSchema($resolvers);

header('Content-Type: application/json');

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

$query = $input['query'] ?? null;
$variables = $input['variables'] ?? null;

if (!$query) {
    http_response_code(400);
    echo json_encode(['error' => 'Query is required']);
    exit;
}

try {
    $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
    $output = $result->toArray();
    echo json_encode($output);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

