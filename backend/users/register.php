<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';
    
    try {
        validateRole(3);
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            sendResponse(405, "Método no permitido");
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['name'], $data['last_name'], $data['email'], $data['password'], $data['rol_id'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }
    
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            sendResponse(400, "El correo no es un formato válido");
        }
    
        if(strlen($data['password']) < 8) {
            sendResponse(400, "La contraseña debe de contener al menos 8 caracteres");
        }

        $checkEmail = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmail->execute([$data['email']]);
    
        if($checkEmail->rowCount() > 0) {
            sendResponse(400, "El correo ya existe");
        }
    
        $query = $pdo->prepare("INSERT INTO users (name, last_name, email, password, rol_id) VALUES (?, ?, ?, ?, ?)");
        $query->execute([
            $data['name'],
            $data['last_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['rol_id']
        ]);
    
        sendResponse(200, "Registro creado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>