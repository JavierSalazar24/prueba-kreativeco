<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        validateRole(2);

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            sendResponse(405, "Método no permitido");
        }
    
        $query = $pdo->prepare("SELECT * FROM roles WHERE deleted = false");

        $query->execute();
        $roles = $query->fetchAll(PDO::FETCH_ASSOC);

        sendResponse(200, "Lista de roles", $roles);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>