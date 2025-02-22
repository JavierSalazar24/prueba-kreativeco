<?php

    require 'vendor/autoload.php';

    use Dotenv\Dotenv;

    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad(); 
    }

try {
    $DB_HOST = $_ENV['DB_HOST'];
    $DB_NAME = $_ENV['DB_NAME'];
    $DB_USER = $_ENV['DB_USER'];
    $DB_PASSWORD = $_ENV['DB_PASSWORD'];

    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error en la conexión a la base de datos", "error" => $e->getMessage()]);
    exit;
}
?>