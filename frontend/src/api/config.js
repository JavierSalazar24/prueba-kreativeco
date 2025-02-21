import iziToast from 'izitoast'
import axios from 'axios'
import { API_HOST } from '@/config'

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
      iziToast.error({
        message: error.response?.data?.message || 'Error en el servidor',
        timeout: 2000,
      })
      throw new Error(error.message)
    }
  },

  async post(url, data) {
    try {
      const response = await apiClient.post(url, data)
      iziToast.info({ message: response.data.message, timeout: 2000 })
      return response.data
    } catch (error) {
      iziToast.error({
        message: error.response?.data?.message || 'Error en el servidor',
        timeout: 2000,
      })
      throw new Error(error.message)
    }
  },

  async put(url, data) {
    try {
      const response = await apiClient.put(url, data)
      iziToast.success({ message: response.data.message, timeout: 2000 })
      return response.data
    } catch (error) {
      iziToast.error({
        message: error.response?.data?.message || 'Error en el servidor',
        timeout: 2000,
      })
      throw new Error(error.message)
    }
  },

  async delete(url, id) {
    try {
      const response = await apiClient.delete(url, { data: id })
      iziToast.success({ message: response.data.message, timeout: 2000 })
      return response.data
    } catch (error) {
      iziToast.error({
        message: error.response?.data?.message || 'Error en el servidor',
        timeout: 2000,
      })
      throw new Error(error.message)
    }
  },
}
