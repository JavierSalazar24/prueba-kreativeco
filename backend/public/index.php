<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/app.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $segments = explode('/', $uri);
    
    if ($uri === '' || $uri === 'index.php') {
        require_once __DIR__ . '/../views/home.php';
        exit;
    }
    
    $routes = ['users', 'posts', 'roles', 'auth'];
    
    $baseRoute = isset($segments[1]) ? $segments[1] : null;
    $id = isset($segments[2]) ? (int) $segments[2] : null;
    
    if ($baseRoute === 'auth') {
        require_once __DIR__ . '/../app/routes/auth.php';
        exit;
    } elseif (in_array($baseRoute, $routes)) {
        $routeFile = __DIR__ . "/../app/routes/{$baseRoute}.php";
        if (file_exists($routeFile)) {
            require_once $routeFile;
            exit;
        }
    }
    
    throw new Exception("Ruta no encontrada", 404);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    require_once __DIR__ . '/../views/404.php';
}