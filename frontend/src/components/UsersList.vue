<script setup>
import Swal from 'sweetalert2'
import { useUserStore } from '@/stores/userStore'
import { useRoles } from '@/composables/useRoles'
import LoaderCard from './LoaderCard.vue'
import EmptyCard from './EmptyCard.vue'
import CardBase from './CardBase.vue'

const userStore = useUserStore()

if (userStore.items.length === 0) userStore.loadItems()

const { hasPermission } = useRoles()

const updateUserId = (user) => {
  userStore.itemToEdit = { ...user }
}

const deleteUserId = async (id) => {
  Swal.fire({
    title: 'Are you sure to remove it?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then(async (result) => {
    try {
      if (result.isConfirmed) await userStore.removeItem(id)
    } catch (error) {
      console.log(error)
    }
  })
}
</script>

<template>
  <div class="container-list">
    <h2>Users</h2>

    <LoaderCard v-if="userStore.loading" />
    <EmptyCard v-else-if="userStore.items.length === 0" />
    <div v-else class="cards-container">
      <CardBase
        v-for="user in userStore.items"
        :key="user.id"
        :title="`${user.name} ${user.last_name}`"
        :description="user.email"
        :subText="`${user.rol_name} (Permisos: ${user.permissions.split(',').join(', ')}).`"
        :canEdit="hasPermission('actualizar')"
        :canDelete="hasPermission('eliminar')"
        :store="userStore"
        @edit="updateUserId(user)"
        @delete="deleteUserId(user.id)"
      />
    </div>
  </div>
</template>
