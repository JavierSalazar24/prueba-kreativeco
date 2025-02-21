<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../utils/response.php';

    try {

        validateRole(2);

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            sendResponse(405, "Método no permitido");
        }
    
        $query = $pdo->prepare("SELECT posts.id, posts.title, posts.description, posts.date_created, 
                        CONCAT(users.name, ' ', users.last_name) AS author, roles.name 
                        FROM posts 
                        INNER JOIN users ON posts.user_id = users.id
                        INNER JOIN roles ON users.rol_id = roles.id
                        WHERE posts.deleted = false
                        ORDER BY posts.date_created DESC");

        $query->execute();
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        
        sendResponse(200, "Lista de publicaciones", $posts);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>