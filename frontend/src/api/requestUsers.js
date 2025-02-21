import axios from 'axios'
import iziToast from 'izitoast'
import { apiService } from './config'

export const loginUser = async (userData) => {
  try {
    const response = await axios.post('http://localhost:8000/users/login.php', userData)
    const { token, user } = response.data

    localStorage.setItem('token', token)
    localStorage.setItem('user', JSON.stringify(user))
    localStorage.setItem('logged', 'true')

    return user
  } catch (error) {
    iziToast.error({
      message: error.response.data.message || 'Error en el servidor',
      timeout: 2000,
    })
    throw new Error(error.message)
  }
}

export const getCheckAuth = () => apiService.get('auth.php')
export const registerUser = (user) => apiService.post('users/register.php', user)
export const fetchUsers = () => apiService.get('users/get_users.php')
export const updateUser = (user) => apiService.put('users/update_user.php', user)
export const deleteUser = (id) => apiService.delete('users/delete_user.php', id)
