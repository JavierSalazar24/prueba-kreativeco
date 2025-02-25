<?php
namespace Middleware;

require_once __DIR__ . '/../../config/app.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Database;
use Utils\Response;
use PDO;

class AuthMiddleware {
    public static function verifyToken() {
        $pdo = Database::connect();
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            Response::sendResponse(401, "Token no proporcionado");
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);

        $query = $pdo->prepare("SELECT * FROM revoked_tokens WHERE token = ?");
        $query->execute([$token]);
        if ($query->fetch()) {
            Response::sendResponse(401, "Token revocado, inicie sesión nuevamente");
        }

        try {
            $decoded = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            Response::sendResponse(401, "Token inválido o expirado");
        }
    }

    public static function validateRole($level) {
        $user = self::verifyToken();
        if ($user['rol_level'] < $level) {
            Response::sendResponse(403, "No tienes permisos");
        }
        return $user;
    }
}