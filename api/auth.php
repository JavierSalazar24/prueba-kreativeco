<?php
require 'authMiddleware.php';
require './utils/response.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $user = verifyToken();
        sendResponse(200, "usuario", $user);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
}