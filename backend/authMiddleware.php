<?php

require 'vendor/autoload.php';
require 'connection.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad(); 
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function verifyToken() {
    global $pdo;
    
    $headers = apache_request_headers();
    
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["message" => "Token no proporcionado"]);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    $query = $pdo->prepare("SELECT * FROM revoked_tokens WHERE token = ?");
    $query->execute([$token]);
    if ($query->fetch()) {
        sendResponse(401, "Token revocado, inicie sesión nuevamente");
    }

    try {
        $decoded = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'));
        return (array) $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["message" => "Token inválido"]);
        exit;
    }
}

function validateRole($level) {
    $user = verifyToken();
    if ($user['rol_level'] < $level) {
        http_response_code(403);
        echo json_encode(["message" => "No tienes permisos"]);
        exit;
    }
    return $user;
}