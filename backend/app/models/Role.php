<?php
namespace Models;
use Config\Database;
use PDO;
use PDOException;

class Role {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function getAll() {
        try {
            $query = $this->pdo->prepare("SELECT * FROM roles WHERE deleted = false");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($data) {
        try {
            $checkRole = $this->pdo->prepare("SELECT permission_level FROM roles WHERE permission_level = ?");
            $checkRole->execute([$data['permission_level']]);

            if ($checkRole->rowCount() > 0) {
                return ["error" => "El nivel de permisos ya existe"];
            }

            $query = $this->pdo->prepare("INSERT INTO roles (name, permission_level) VALUES (?, ?)");
            return $query->execute([$data['name'], $data['permission_level']]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($data) {
        try {
            $checkQuery = $this->pdo->prepare("SELECT id FROM roles WHERE id = ?");
            $checkQuery->execute([$data['id']]);

            if ($checkQuery->rowCount() === 0) {
                return ["error" => "Registro no encontrado"];
            }

            $checkRole = $this->pdo->prepare("SELECT id FROM roles WHERE permission_level = ? AND id != ?");
            $checkRole->execute([$data['permission_level'], $data['id']]);

            if ($checkRole->rowCount() > 0) {
                return ["error" => "El nivel de permisos ya existe en otro rol"];
            }

            $query = $this->pdo->prepare("UPDATE roles SET name = ?, permission_level = ? WHERE id = ?");
            return $query->execute([$data['name'], $data['permission_level'], $data['id']]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $query = $this->pdo->prepare("UPDATE roles SET deleted = true WHERE id = ?");
            $query->execute([$id]);

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}