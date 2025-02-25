<?php
namespace Controllers;
use Models\Role;
use Utils\Response;

class RoleController {
    private $roleModel;

    public function __construct() {
        $this->roleModel = new Role();
    }

    public function getRoles() {
        try {
            $roles = $this->roleModel->getAll();
            Response::sendResponse(200, "Lista de roles", $roles);
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al obtener los roles", ["error" => $e->getMessage()]);
        }
    }

    public function createRole($data) {
        try {
            if (!isset($data['name'], $data['permissions'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }
    
            $result = $this->roleModel->create($data);
    
            if (isset($result["error"])) {
                Response::sendResponse(400, $result["error"]);
            }
    
            Response::sendResponse(201, "Rol creado correctamente");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al crear el rol", ["error" => $e->getMessage()]);
        }
    }

    public function updateRole($id, $data) {
        try {
            if (!$id || !isset($data['name'], $data['permissions'])) {
                Response::sendResponse(400, "Todos los campos son obligatorios");
            }
    
            $data['id'] = $id;
            $result = $this->roleModel->update($data);
    
            if (isset($result["error"])) {
                Response::sendResponse(400, $result["error"]);
            }
    
            Response::sendResponse(200, "Rol actualizado correctamente");
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al actualizar el rol", ["error" => $e->getMessage()]);
        }
    }

    public function deleteRole($id) {
        try {
            if (!$id) {
                Response::sendResponse(400, "El ID es obligatorio");
            }
            if ($this->roleModel->delete($id)) {
                Response::sendResponse(200, "Rol eliminado");
            } else {
                Response::sendResponse(404, "Rol no encontrado");
            }
        } catch (Exception $e) {
            Response::sendResponse(500, "Error al eliminar el rol", ["error" => $e->getMessage()]);
        }
    }
}