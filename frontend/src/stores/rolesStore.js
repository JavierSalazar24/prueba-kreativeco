import { fetchRoles, createRole, updateRole, deleteRole } from '@/api/requestRoles'
import { useGeneralStore } from './generalStore'

export const useRoleStore = useGeneralStore('roles', {
  fetchAll: fetchRoles,
  create: createRole,
  update: updateRole,
  delete: deleteRole,
})
