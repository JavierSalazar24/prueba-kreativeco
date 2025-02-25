<?php
namespace Controllers;

use Middleware\AuthMiddleware;
use Models\User;
use Utils\Response;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login($data) {
        try {
            if (!isset($data['email'], $data['password'])) {
                Response::sendResponse(400, "El correo y la contraseña son obligatorios");
            }
    
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                Response::sendResponse(400, "El correo no tiene un formato válido");
            }
    
            if(strlen($data['password']) < 8) {
                Response::sendResponse(400, "La contraseña debe contener al menos 8 caracteres");
            }
    
            $user = $this->userModel->getByEmail($data['email']);
    
            if ($user && password_verify($data['password'], $user['password'])) {
                $token = JWT::encode([
                    "id" => $user['id'], 
                    "name" => $user['name'], 
                    "last_name" => $user['last_name'], 
                    "email" => $user['email'], 
                    "rol" => $user['rol_name'],
                    "rol_level" => $user['rol_level'],
                    "exp" => time() + (7 * 24 * 60 * 60)
                ], $_ENV['SECRET_KEY'], 'HS256');
            
                Response::sendResponse(200, "Login exitoso", [
                    "token" => $token,
                    "user" => [
                        "id" => $user['id'],
                        "name" => $user['name'],
                        "last_name" => $user['last_name'],
                        "email" => $user['email'],
                        "rol" => $user['rol_name'],
                        "rol_level" => $user['rol_level']
                    ]
                ]);
            } else {
                Response::sendResponse(401, "Credenciales inválidas");
            }
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al logearse", ["error" => $e->getMessage()]);
        }
    }

    public function checkAuth() {
        try {
            $user = AuthMiddleware::verifyToken();
            Response::sendResponse(200, "Usuario autenticado", $user);
        } catch (Exception $e) {
            Response::sendResponse(401, "Token inválido o expirado");
        }
    }

    public function logout($headers) {
        try {
            if (!isset($headers['Authorization'])) {
                Response::sendResponse(400, "Token no proporcionado");
            }
    
            $token = str_replace('Bearer ', '', $headers['Authorization']);
    
            $this->userModel->revokeToken($token);
    
            Response::sendResponse(200, "Logout exitoso");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error en el servidor", ["error" => $e->getMessage()]);
        }
    }
}
?>