import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useLoginStore } from '@/stores/loginStore'
import { loginUser } from '@/api/requestUsers'
import { loginSchema } from '@/schemas/validateSchemas'

export function useLoginForm() {
  const router = useRouter()
  const loginStore = useLoginStore()

  const email = ref('')
  const password = ref('')
  const errorsMessage = ref({})

  if (loginStore.logged) router.push('/')

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
      const userData = await loginUser({ email: email.value, password: password.value })
      loginStore.user = userData
      loginStore.logged = true
      resetForm()
      router.push('/')
    } catch (error) {
      console.error(error)
    }
  }

  return {
    email,
    password,
    errorsMessage,
    handleLogin,
    resetForm,
  }
}
