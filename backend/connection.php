<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=kreativeco;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error en la conexión a la base de datos", "error" => $e->getMessage()]);
    exit;
}
?>