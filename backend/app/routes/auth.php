<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Controllers\AuthController;
use Utils\Response;

$controller = new AuthController();
$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/');
$action = explode('/', $uri)[2];

try {
    switch ($method) {
        case 'POST':
            if ($action === 'login') {
                $data = json_decode(file_get_contents("php://input"), true);
                $controller->login($data);
            } elseif ($action === 'logout') {
                $headers = apache_request_headers();
                $controller->logout($headers);
            } else {
                Response::sendResponse(404, "Ruta no encontrada");
            }
            break;
    
        case 'GET':
            if ($action === 'check') {
                $controller->checkAuth();
            } else {
                Response::sendResponse(404, "Ruta no encontrada");
            }
            break;
        
        default:
            Response::sendResponse(405, "Método no permitido");
    }
} catch (Exception $e) {
    Response::sendResponse(500, "Error interno del servidor", ["error" => $e->getMessage()]);
}
?>