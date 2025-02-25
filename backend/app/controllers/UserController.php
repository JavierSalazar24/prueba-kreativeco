<?php
namespace Controllers;
use Models\User;
use Utils\Response;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function getUsers() {
        try {
            $users = $this->userModel->getAll();
            Response::sendResponse(200, "Lista de usuarios", $users);
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al obtener a los usuarios", ["error" => $e->getMessage()]);
        }
    }

    public function createUser($data) {
        try {
            if (!isset($data['name'], $data['last_name'], $data['email'], $data['password'], $data['rol_id'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                sendResponse(400, "El correo no es un formato válido");
            }
            if(strlen($data['password']) < 8) {
                Response::sendResponse(400, "La contraseña debe de contener al menos 8 caracteres");
            }
    
            $emailExist = $this->userModel->checkEmailExist($data['email']);
            if($emailExist->rowCount() > 0) {
                Response::sendResponse(400, "El correo ya existe");
            }
            
            $this->userModel->create($data);
            Response::sendResponse(201, "Usuario creado");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al crear el usuario", ["error" => $e->getMessage()]);
        }
    }

    public function updateUser($id, $data) {
        try {
            if (!$id || !isset($data['name'], $data['last_name'], $data['email'], $data['rol_id'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }

            $user = $this->userModel->getById($id);
            if (!$user) {
                Response::sendResponse(404, "Registro no encontrado");
            }

            if($user['email'] !== $data['email']) {
                $emailExist = $this->userModel->checkEmailExist($data['email']);
                if($emailExist->rowCount() > 0) {
                    Response::sendResponse(400, "El correo ya existe");
                }
            }


            $data['id'] = $id;
            $this->userModel->update($data);
            Response::sendResponse(200, "Usuario actualizado");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al actualizar el usuario", ["error" => $e->getMessage()]);
        }
    }

    public function deleteUser($id) {
        try {
            if (!$id) {
                Response::sendResponse(400, "El ID es obligatorio");
            }
            if ($this->userModel->delete($id)) {
                Response::sendResponse(200, "Usuario eliminado");
            } else {
                Response::sendResponse(404, "Usuario no encontrado");
            }
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al eliminar el usuario", ["error" => $e->getMessage()]);
        }
    }
}

?>