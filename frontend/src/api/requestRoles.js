import { apiService } from './config'

export const fetchRoles = () => apiService.get('roles')
export const createRole = (role) => apiService.post('roles', role)
export const updateRole = (role) => apiService.put('roles', role)
export const deleteRole = (id) => apiService.delete('roles', id)
