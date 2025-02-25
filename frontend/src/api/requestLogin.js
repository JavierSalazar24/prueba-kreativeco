import { apiService } from './config'

export const loginUser = (user) => apiService.login('auth/login', user)
export const logoutUser = () => apiService.post('auth/logout')
export const getCheckAuth = () => apiService.get('auth/check')
