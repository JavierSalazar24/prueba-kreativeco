import { apiService } from './config'

export const loginUser = (user) => apiService.login('users/login.php', user)
export const logoutUser = () => apiService.post('users/logout.php')
export const getCheckAuth = () => apiService.get('auth.php')
export const registerUser = (user) => apiService.post('users/register.php', user)
export const fetchUsers = () => apiService.get('users/get_users.php')
export const updateUser = (user) => apiService.put('users/update_user.php', user)
export const deleteUser = (id) => apiService.delete('users/delete_user.php', id)
