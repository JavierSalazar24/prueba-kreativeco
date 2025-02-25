<?php
namespace Models;
use Config\Database;
use PDO;
use PDOException;
use Exception;

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
            $permissionsString = implode(',', $data['permissions']);

            $query = $this->pdo->prepare("INSERT INTO roles (name, permissions) VALUES (?, ?)");
            return $query->execute([$data['name'], $permissionsString]);
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

            $permissionsString = implode(',', $data['permissions']);

            $query = $this->pdo->prepare("UPDATE roles SET name = ?, permissions = ? WHERE id = ?");
            return $query->execute([$data['name'], $permissionsString, $data['id']]);
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