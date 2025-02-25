import { fetchUsers, createUser, updateUser, deleteUser } from '@/api/requestUsers'
import { useGeneralStore } from './generalStore'

export const useUserStore = useGeneralStore('user', {
  fetchAll: fetchUsers,
  create: createUser,
  update: updateUser,
  delete: deleteUser,
})
