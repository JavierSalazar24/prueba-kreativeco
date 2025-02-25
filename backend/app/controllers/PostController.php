<?php
namespace Controllers;
use Models\Post;
use Utils\Response;

class PostController {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function getPosts() {
        try {
            $posts = $this->postModel->getAll();
            Response::sendResponse(200, "Lista de publicaciones", $posts);
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al obtener publicaciones", ["error" => $e->getMessage()]);
        }
    }

    public function getMyPosts($userId) {
        try {
            $posts = $this->postModel->getByUser($userId);
            Response::sendResponse(200, "Tus publicaciones", $posts);
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al obtener tus publicaciones", ["error" => $e->getMessage()]);
        }
    }

    public function createPost($data, $userId) {
        try {
            if (!isset($data['title'], $data['description'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }
            $this->postModel->create($data, $userId);
            Response::sendResponse(201, "Publicación creada");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al crear la publicación", ["error" => $e->getMessage()]);
        }
    }

    public function updatePost($id, $data) {
        try {
            if (!$id || !isset($data['title'], $data['description'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }

            $data['id'] = $id;
            $result = $this->postModel->update($data);

            if (isset($result["error"])) {
                Response::sendResponse(400, $result["error"]);
            }

            Response::sendResponse(200, "Publicación actualizada");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al actualizar la publicación", ["error" => $e->getMessage()]);
        }
    }

    public function deletePost($id) {
        try {
            if (!$id) {
                Response::sendResponse(400, "El ID es obligatorio");
            }

            if ($this->postModel->delete($id)) {
                Response::sendResponse(200, "Publicación eliminada");
            } else {
                Response::sendResponse(404, "Publicación no encontrada");
            }
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al eliminar la publicación", ["error" => $e->getMessage()]);
        }
    }
}

?>