import { apiService } from './config'

export const fetchUsers = () => apiService.get('users')
export const createUser = (user) => apiService.post('users', user)
export const updateUser = (user) => apiService.put('users', user)
export const deleteUser = (id) => apiService.delete('users', id)
