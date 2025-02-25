<?php
namespace Models;
use Config\Database;
use PDO;
use PDOException;
use Exception;

class Post {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function getAll() {
        try {
            $query = $this->pdo->prepare("SELECT posts.id, posts.title, posts.description, posts.date_created, 
                            CONCAT(users.name, ' ', users.last_name) AS author, roles.name 
                            FROM posts 
                            INNER JOIN users ON posts.user_id = users.id
                            INNER JOIN roles ON users.rol_id = roles.id
                            WHERE posts.deleted = false
                            ORDER BY posts.date_created DESC");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getByUser($userId) {
        try {
            $query = $this->pdo->prepare("SELECT posts.id, posts.title, posts.description, posts.date_created, 
                            CONCAT(users.name, ' ', users.last_name) AS author, roles.name 
                            FROM posts 
                            INNER JOIN users ON posts.user_id = users.id
                            INNER JOIN roles ON users.rol_id = roles.id
                            WHERE posts.deleted = false AND posts.user_id = ?
                            ORDER BY posts.date_created DESC");
            $query->execute([$userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($data, $userId) {
        try {
            $query = $this->pdo->prepare("INSERT INTO posts (title, description, user_id) VALUES (?, ?, ?)");
            return $query->execute([$data['title'], $data['description'], $userId]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($data) {
        try {
            $checkQuery = $this->pdo->prepare("SELECT id FROM posts WHERE id = ?");
            $checkQuery->execute([$data['id']]);

            if ($checkQuery->rowCount() === 0) {
                return ["error" => "Registro no encontrado"];
            }

            $query = $this->pdo->prepare("UPDATE posts SET title = ?, description = ? WHERE id = ?");
            return $query->execute([$data['title'], $data['description'], $data['id']]);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $query = $this->pdo->prepare("UPDATE posts SET deleted = true WHERE id = ?");
            $query->execute([$id]);

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}