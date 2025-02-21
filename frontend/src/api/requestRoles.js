import { apiService } from './config'

export const fetchRoles = () => apiService.get('roles/get_roles.php')
export const createRole = (role) => apiService.post('roles/create_role.php', role)
export const updateRole = (role) => apiService.put('roles/update_role.php', role)
export const deleteRole = (id) => apiService.delete('roles/delete_role.php', id)
