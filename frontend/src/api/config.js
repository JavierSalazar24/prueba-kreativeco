import axios from 'axios'
import { API_HOST } from '@/config'
import { notification } from '@/utils/notification'

export const apiClient = axios.create({
  baseURL: API_HOST,
  headers: {
    'Content-Type': 'application/json',
  },
})

apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }

    return config
  },
  (error) => {
    return Promise.reject(error)
  },
)

export const apiService = {
  async get(url) {
    try {
      const response = await apiClient.get(url)
      const { data } = response.data
      return data
    } catch (error) {
      notification(error.response?.data?.message || 'Error en el servidor', 'error')
      throw new Error(error.message)
    }
  },

  async post(url, data) {
    try {
      const { id } = data
      const response = await apiClient.post(`${url}/${id}`, data)
      notification(response.data.message, 'info')
      return response.data
    } catch (error) {
      notification(error.response?.data?.message || 'Error en el servidor', 'error')
      throw new Error(error.message)
    }
  },

  async put(url, data) {
    try {
      const { id } = data
      const response = await apiClient.put(`${url}/${id}`, data)
      notification(response.data.message, 'success')
      return response.data
    } catch (error) {
      notification(error.response?.data?.message || 'Error en el servidor', 'error')
      throw new Error(error.message)
    }
  },

  async delete(url, id) {
    try {
      const response = await apiClient.delete(`${url}/${id}`)
      notification(response.data.message, 'success')
      return response.data
    } catch (error) {
      notification(error.response?.data?.message || 'Error en el servidor', 'error')
      throw new Error(error.message)
    }
  },

  async login(url, user) {
    try {
      const response = await apiClient.post(url, user)
      const { data } = response.data
      const { token, user: userLogin } = data

      localStorage.setItem('token', token)
      localStorage.setItem('user', JSON.stringify(userLogin))
      localStorage.setItem('logged', 'true')

      return userLogin
    } catch (error) {
      notification(error.response?.data?.message || 'Error en el servidor', 'error')
      throw new Error(error.message)
    }
  },
}
