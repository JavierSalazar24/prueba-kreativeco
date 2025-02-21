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
    
        if (!isset($data['id'], $data['name'], $data['last_name'], $data['rol_id'], $data['email'])) {
            sendResponse(400, "Todos los campos son obligatorios");
        }

        $checkQuery = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $checkQuery->execute([$data['id']]);
        $user = $checkQuery->fetch(PDO::FETCH_ASSOC);

        if ($checkQuery->rowCount() === 0) {
            sendResponse(404, "Registro no encontrado");
        }

        if (!isset($data['password'])) {
            $pass = $user['password'];
        }else{
            $pass = password_hash($data['password'], PASSWORD_BCRYPT);
        }
    
        $query = $pdo->prepare("UPDATE users SET name = ?, last_name = ?, email = ?, password = ?, rol_id = ? WHERE id = ?");
        $query->execute([$data['name'], $data['last_name'], $data['email'], $pass, $data['rol_id'], $data['id']]);
    
        sendResponse(200, "Registro actualizado");
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>