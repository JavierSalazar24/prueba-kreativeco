<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        validateRole(4);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            sendResponse(405, "Método no permitido");
        }
    
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['id'], $data['name'], $data['permission_level'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }

        $checkQuery = $pdo->prepare("SELECT id FROM roles WHERE id = ?");
        $checkQuery->execute([$data['id']]);

        if ($checkQuery->rowCount() === 0) {
            sendResponse(404, "Registro no encontrado");
        }

        $checkRole = $pdo->prepare("SELECT id FROM roles WHERE permission_level = ? AND id != ?");
        $checkRole->execute([$data['permission_level'], $data['id']]);
    
        if($checkRole->rowCount() > 0) {
            sendResponse(400, "El nivel de permisos ya existe en otro rol");
        }
    
        $query = $pdo->prepare("UPDATE roles SET name = ?, permission_level = ? WHERE id = ?");
        $query->execute([$data['name'], $data['permission_level'], $data['id']]);
    
        sendResponse(200, "Registro actualizado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>