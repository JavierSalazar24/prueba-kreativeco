import { fetchUsers, registerUser, updateUser, deleteUser } from '@/api/requestUsers'
import { useGeneralStore } from './generalStore'

export const useUserStore = useGeneralStore('user', {
  fetchAll: fetchUsers,
  create: registerUser,
  update: updateUser,
  delete: deleteUser,
})
