import { getCheckAuth } from '@/api/requestUsers'
import iziToast from 'izitoast'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useLoginStore = defineStore('login', () => {
  const user = ref(JSON.parse(localStorage.getItem('user')) || {})
  const logged = ref(localStorage.getItem('logged') === 'true')

  const checkAuth = async () => {
    const token = localStorage.getItem('token')
    if (!token) return

    try {
      const data = await getCheckAuth()
      if (data) {
        user.value = data
        logged.value = true
        localStorage.setItem('user', JSON.stringify(data))
        localStorage.setItem('logged', 'true')
      } else {
        logout()
      }
    } catch {
      iziToast.error({
        message: 'Token no válido',
        timeout: 2000,
      })
      logout()
    }
  }

  const logout = () => {
    localStorage.removeItem('user')
    localStorage.removeItem('logged')
    localStorage.removeItem('token')
    window.location.href = '/login'
  }

  return { checkAuth, logout, logged, user }
})
