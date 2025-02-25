<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Controllers\PostController;
use Middleware\AuthMiddleware;
use Utils\Response;

$controller = new PostController();
$user = AuthMiddleware::verifyToken();

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$segments = explode('/', trim($uri, '/'));
$id = isset($segments[2]) ? (int) $segments[2] : null;

try {
    switch ($method) {
        case 'GET':
            AuthMiddleware::validatePermission('consulta');
            if (isset($_GET['me'])) {
                $controller->getMyPosts($user['id']);
            } else {
                $controller->getPosts();
            }
            break;

        case 'POST':
            AuthMiddleware::validatePermission('agregar');
            $data = json_decode(file_get_contents("php://input"), true);
            $controller->createPost($data, $user['id']);
            break;

        case 'PUT':
            AuthMiddleware::validatePermission('actualizar');
            $data = json_decode(file_get_contents("php://input"), true);
            if ($id) {
                $controller->updatePost($id, $data);
            } else {
                Response::sendResponse(400, "ID de usuario requerido");
            }
            break;

        case 'DELETE':
            AuthMiddleware::validatePermission('eliminar');
            $data = json_decode(file_get_contents("php://input"), true);
            if ($id) {
                $controller->deletePost($id);
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