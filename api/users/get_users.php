<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {
        
        validateRole(2);
    
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            sendResponse(405, "Método no permitido");
        }
    
        $query = $pdo->prepare("SELECT users.id, users.name, users.last_name, users.email, roles.id AS rol_id, roles.name AS rol_name, roles.permission_level
                         FROM users INNER JOIN roles ON users.rol_id = roles.id WHERE users.deleted = false");

        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        sendResponse(200, "Lista de usuarios", $users);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>