<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Controllers\UserController;
use Middleware\AuthMiddleware;
use Utils\Response;

$controller = new UserController();
$user = AuthMiddleware::verifyToken();

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$segments = explode('/', trim($uri, '/'));
$id = isset($segments[2]) ? (int) $segments[2] : null;

try {
    switch ($method) {
        case 'GET':
            AuthMiddleware::validateRole(2);
            $controller->getUsers();
            break;
        
        case 'POST':
            AuthMiddleware::validateRole(3);
            $data = json_decode(file_get_contents("php://input"), true);
            $controller->createUser($data);
            break;
        
        case 'PUT':
            AuthMiddleware::validateRole(4);
            $data = json_decode(file_get_contents("php://input"), true);
            if ($id) {
                $controller->updateUser($id, $data);
            } else {
                Response::sendResponse(400, "ID de usuario requerido");
            }
            break;
        
        case 'DELETE':
            AuthMiddleware::validateRole(5);
            $data = json_decode(file_get_contents("php://input"), true);
            if ($id) {
                $controller->deleteUser($id);
            } else {
                Response::sendResponse(400, "ID de usuario requerido");
            }
            break;
        
        default:
            sendResponse(405, "Método no permitido");
    }
} catch (Exception $e) {
    Response::sendResponse(500, "Error interno del servidor", ["error" => $e->getMessage()]);
}
?>