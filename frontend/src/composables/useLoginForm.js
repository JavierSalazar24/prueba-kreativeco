import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useLoginStore } from '@/stores/loginStore'
import { loginSchema } from '@/schemas/validateSchemas'

export function useLoginForm() {
  const router = useRouter()
  const loginStore = useLoginStore()

  if (loginStore.logged) router.push('/')

  const email = ref('')
  const password = ref('')
  const errorsMessage = ref({})
  const loading = ref(false)

  const resetForm = () => {
    email.value = ''
    password.value = ''
    errorsMessage.value = {}
  }

  const validateForm = () => {
    const validationResult = loginSchema.safeParse({ email: email.value, password: password.value })
    if (!validationResult.success) {
      errorsMessage.value = Object.fromEntries(
        Object.entries(validationResult.error.format()).map(([key, val]) => [
          key,
          val._errors[0] || '',
        ]),
      )
      return false
    }
    errorsMessage.value = {}
    return true
  }

  const handleLogin = async () => {
    if (!validateForm()) return

    try {
      loading.value = true
      const data = { email: email.value, password: password.value }
      await loginStore.login(data)
      resetForm()
      router.push('/')
    } catch (error) {
      console.error(error)
    } finally {
      loading.value = false
    }
  }

  return {
    email,
    password,
    errorsMessage,
    handleLogin,
    resetForm,
    loading,
  }
}
