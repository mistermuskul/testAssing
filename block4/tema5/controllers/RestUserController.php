<?php

class RestUserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        header('Content-Type: application/json');

        if (preg_match('#^/api/users/(\d+)$#', $path, $matches)) {
            $id = (int)$matches[1];
            
            if ($method === 'GET') {
                $this->getUser($id);
            } elseif ($method === 'PUT' || $method === 'PATCH') {
                $this->updateUser($id);
            } elseif ($method === 'DELETE') {
                $this->deleteUser($id);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
        } elseif ($path === '/api/users') {
            if ($method === 'GET') {
                $this->getUsers();
            } elseif ($method === 'POST') {
                $this->createUser();
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
        }
    }

    private function getUsers()
    {
        $users = $this->userService->getUsers();
        echo json_encode($users);
    }

    private function getUser($id)
    {
        $user = $this->userService->getUserById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    private function createUser()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Name is required']);
            return;
        }

        $name = $data['name'];
        $email = $data['email'] ?? null;
        
        $user = $this->userService->createUser($name, $email);
        http_response_code(201);
        echo json_encode($user);
    }

    private function updateUser($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Name is required']);
            return;
        }

        $name = $data['name'];
        $email = $data['email'] ?? null;
        
        $user = $this->userService->updateUser($id, $name, $email);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    private function deleteUser($id)
    {
        $result = $this->userService->deleteUser($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}

