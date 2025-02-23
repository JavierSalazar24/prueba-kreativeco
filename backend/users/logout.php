<?php
require '../connection.php';
require '../authMiddleware.php';
require '../utils/response.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(405, "Método no permitido");
    }

    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        sendResponse(400, "Token no proporcionado");
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);

    $query = $pdo->prepare("INSERT INTO revoked_tokens (token) VALUES (?)");
    $query->execute([$token]);

    sendResponse(200, "Logout exitoso");
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
}
?>