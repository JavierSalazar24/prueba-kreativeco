<?php
namespace Models;
use Config\Database;
use PDO;
use PDOException;
use Exception;

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function getAll() {
        try {
            $query = $this->pdo->prepare("SELECT users.id, users.name, users.last_name, users.email, roles.id AS rol_id, roles.name AS rol_name, roles.permissions
            FROM users INNER JOIN roles ON users.rol_id = roles.id WHERE users.deleted = false");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $query = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $query->execute([$id]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($data) {
        try {
            $query = $this->pdo->prepare("INSERT INTO users (name, last_name, email, password, rol_id) VALUES (?, ?, ?, ?, ?)");
            return $query->execute([
                $data['name'],
                $data['last_name'],
                $data['email'],
                password_hash($data['password'], PASSWORD_BCRYPT),
                $data['rol_id']
            ]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($data) {
        try {
            if (!isset($data['password'])) {
                $user = $this->getById($data['id']);
                $pass = $user['password'];
            }else{
                $pass = password_hash($data['password'], PASSWORD_BCRYPT);
            }
        
            
            $query = $this->pdo->prepare("UPDATE users SET name = ?, last_name = ?, email = ?, password = ?, rol_id = ? WHERE id = ?");
            return $query->execute([
                $data['name'],
                $data['last_name'],
                $data['email'],
                $pass,
                $data['rol_id'],
                $data['id']
            ]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $query = $this->pdo->prepare("UPDATE users SET deleted = true WHERE id = ?");
            $query->execute([$id]);

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function checkEmailExist($email){
        try {
            $query = $this->pdo->prepare("SELECT email FROM users WHERE email = ?");
            $query->execute([$email]);
            return $query;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getByEmail($email) {
        try {
            $query = $this->pdo->prepare("SELECT users.id, users.name, users.last_name, users.email, users.password, roles.name AS rol_name, roles.permissions AS roles FROM users INNER JOIN roles ON users.rol_id = roles.id WHERE email = ? AND users.deleted = false");
            $query->execute([$email]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function revokeToken($token) {
        try {
            $query = $this->pdo->prepare("INSERT INTO revoked_tokens (token) VALUES (?)");
            return $query->execute([$token]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}