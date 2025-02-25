<script setup>
import Swal from 'sweetalert2'
import { useRoleStore } from '@/stores/rolesStore'
import { useRoles } from '@/composables/useRoles'
import LoaderCard from './LoaderCard.vue'
import EmptyCard from './EmptyCard.vue'
import CardBase from './CardBase.vue'

const rolesStore = useRoleStore()

if (rolesStore.items.length === 0) rolesStore.loadItems()

const { hasPermission } = useRoles()

const updateRoleId = (role) => {
  rolesStore.itemToEdit = {
    ...role,
    permissions: role.permissions ? role.permissions.split(',') : [],
  }
}

const deleteRoleId = async (id) => {
  Swal.fire({
    title: 'Are you sure to remove it?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then(async (result) => {
    try {
      if (result.isConfirmed) await rolesStore.removeItem(id)
    } catch (error) {
      console.log(error)
    }
  })
}
</script>

<template>
  <div class="container-list">
    <h2>Roles</h2>

    <LoaderCard v-if="rolesStore.loading" />
    <EmptyCard v-else-if="rolesStore.items.length === 0" />
    <div v-else class="cards-container">
      <CardBase
        v-for="role in rolesStore.items"
        :key="role.id"
        :title="role.name"
        :subText="`Permisos: ${role.permissions.split(',').join(', ')}.`"
        :canEdit="hasPermission('actualizar')"
        :canDelete="hasPermission('eliminar')"
        :store="rolesStore"
        @edit="updateRoleId(role)"
        @delete="deleteRoleId(role.id)"
      />
    </div>
  </div>
</template>
