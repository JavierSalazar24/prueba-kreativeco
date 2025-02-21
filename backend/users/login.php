<?php
    require '../connection.php';
    require '../authMiddleware.php';
    require '../vendor/autoload.php';
    require '../utils/response.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            sendResponse(405, "Método no permitido");
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            sendResponse(400, "El correo y la contraseña son obligatorios");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            sendResponse(400, "El correo no tiene un formato válido");
        }

        if(strlen($data['password']) < 8) {
            sendResponse(400, "La contraseña debe contener al menos 8 caracteres");
        }

        $query = $pdo->prepare("SELECT users.id, users.name, users.last_name, users.email, 
                            users.password, roles.name AS rol, roles.permission_level AS rol_level
                            FROM users 
                            INNER JOIN roles ON users.rol_id = roles.id 
                            WHERE email = ?");

        $query->execute([$data['email']]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            $token = JWT::encode([
                "id" => $user['id'], 
                "name" => $user['name'], 
                "last_name" => $user['last_name'], 
                "email" => $user['email'], 
                "rol" => $user['rol'],
                "rol_level" => $user['rol_level'],
                "exp" => time() + (7 * 24 * 60 * 60)
            ], $_ENV['SECRET_KEY'], 'HS256');
        
            http_response_code(200);
            echo json_encode([
                "token" => $token,
                "user" => [
                    "id" => $user['id'],
                    "name" => $user['name'],
                    "last_name" => $user['last_name'],
                    "email" => $user['email'],
                    "rol" => $user['rol'],
                    "rol_level" => $user['rol_level']
                ]
            ]);
        } else {
            sendResponse(401, "Credenciales inválidas");
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error en la base de datos", "error" => $e->getMessage()]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Error interno del servidor", "error" => $e->getMessage()]);
    }
?>