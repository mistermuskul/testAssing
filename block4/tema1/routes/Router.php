<?php

class Router
{
    private $routes = [];

    public function addRoute($path, $controller, $method)
    {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $basePath = dirname($scriptName);
        
        if ($basePath !== '/' && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        $path = rtrim($path, '/');
        
        if ($path === '') {
            $path = '/';
        }

        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $controller = new $route['controller']($this->createDependencies($route['controller']));
            $method = $route['method'];
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    private function createDependencies($controllerClass)
    {
        if ($controllerClass === 'UserController') {
            $db = new Database();
            $pdo = $db->connect();
            $userRepository = new UserRepository($pdo);
            $userService = new UserService($userRepository);
            return $userService;
        }
        return null;
    }
}

