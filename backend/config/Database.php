<?php
namespace Config;
require_once __DIR__ . '/../config/app.php';
use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function connect() {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8",
                    $_ENV['DB_USER'], $_ENV['DB_PASSWORD']
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Error en la conexión a la base de datos", 500);
            }
        }
        return self::$pdo;
    }
}
