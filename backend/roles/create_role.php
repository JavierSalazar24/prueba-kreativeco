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
    
        if (!isset($data['name'], $data['permission_level'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }

        $checkRole = $pdo->prepare("SELECT permission_level FROM roles WHERE permission_level = ?");
        $checkRole->execute([$data['permission_level']]);
    
        if($checkRole->rowCount() > 0) {
            sendResponse(400, "El nivel de permisos ya existe");
        }
    
        $query = $pdo->prepare("INSERT INTO roles (name, permission_level) VALUES (?, ?)");
        $query->execute([$data['name'], $data['permission_level']]);
    
        sendResponse(200, "Registro creado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>