import { computed } from 'vue'
import { useLoginStore } from '@/stores/loginStore'

export function useRoles() {
  const loginStore = useLoginStore()

  const roles = computed(() => (loginStore.user?.roles ? loginStore.user.roles.split(',') : []))
  const logged = computed(() => (loginStore.logged ? true : false))

  const hasPermission = (permission) => roles.value.includes(permission)

  return { roles, hasPermission, logged, logout: loginStore.logout }
}
