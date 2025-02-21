<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        $user = validateRole(4);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            sendResponse(405, "Método no permitido");
        }
    
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'], $data['title'], $data['description'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }

        $checkQuery = $pdo->prepare("SELECT id FROM posts WHERE id = ?");
        $checkQuery->execute([$data['id']]);

        if ($checkQuery->rowCount() === 0) {
            sendResponse(404, "Registro no encontrado");
        }
    
        $query = $pdo->prepare("UPDATE posts SET title = ?, description = ? WHERE id = ?");
        $query->execute([$data['title'], $data['description'], $data['id']]);

        sendResponse(200, "Registro actualizado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>