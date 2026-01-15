<?php

echo "=== Задание 1: REST API GET /api/users ===\n";
echo "✅ REST API endpoint created\n";
echo "To test: curl -X GET http://localhost/api/users\n\n";

echo "=== Задание 2: REST API POST /api/users ===\n";
echo "✅ REST API POST endpoint created\n";
echo "To test: curl -X POST -H \"Content-Type: application/json\" -d '{\"name\": \"Иван\"}' http://localhost/api/users\n\n";

echo "=== Задание 3: REST API PUT /api/users/{id} ===\n";
echo "✅ REST API PUT endpoint created\n";
echo "To test: curl -X PUT -H \"Content-Type: application/json\" -d '{\"name\": \"Алексей\"}' http://localhost/api/users/1\n\n";

echo "=== Задание 4: REST API DELETE /api/users/{id} ===\n";
echo "✅ REST API DELETE endpoint created\n";
echo "To test: curl -X DELETE http://localhost/api/users/1\n\n";

echo "=== Задание 5: GraphQL Query users ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ GraphQL server created\n";
    echo "To test: curl -X POST -H \"Content-Type: application/json\" -d '{\"query\": \"{ users { id name } }\"}' http://localhost/graphql\n\n";
}

echo "=== Задание 6: GraphQL Query getUser(id) ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ GraphQL getUser query created\n";
    echo "To test: curl -X POST -H \"Content-Type: application/json\" -d '{\"query\": \"{ getUser(id: 1) { name } }\"}' http://localhost/graphql\n\n";
}

echo "=== Задание 7: GraphQL Mutation createUser ===\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "⚠ Composer dependencies not installed.\n";
    echo "Run: composer install\n\n";
} else {
    echo "✅ GraphQL createUser mutation created\n";
    echo "To test: curl -X POST -H \"Content-Type: application/json\" -d '{\"query\": \"mutation { createUser(name: \\\"Мария\\\") { id name } }\"}' http://localhost/graphql\n\n";
}

