<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        $user = validateRole(3);
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            sendResponse(405, "Método no permitido");
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['title'], $data['description'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }
    
        $query = $pdo->prepare("INSERT INTO posts (title, description, user_id) VALUES (?, ?, ?)");
        $query->execute([$data['title'], $data['description'], $user['id']]);
    
        sendResponse(200, "Registro creado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>