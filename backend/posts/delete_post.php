<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        validateRole(5);

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            sendResponse(405, "Método no permitido");
        }
    
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            sendResponse(400, "El ID es obligatorio");
        }
    
        $query = $pdo->prepare("UPDATE posts SET deleted = true WHERE id = ?");
        // $query = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $query->execute([$data['id']]);
    
        if ($query->rowCount() > 0) {
            sendResponse(200, "Registro eliminado");
        } else {
            sendResponse(404, "Registro no encontrado");
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>