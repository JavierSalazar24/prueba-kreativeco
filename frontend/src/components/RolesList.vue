<script setup>
import { useLoginStore } from '@/stores/loginStore'
import LoaderCard from './LoaderCard.vue'
import { useRoleStore } from '@/stores/rolesStore'
import EmptyCard from './EmptyCard.vue'
import CardBase from './CardBase.vue'

const loginStore = useLoginStore()
const rolesStore = useRoleStore()

const rol_level = parseInt(loginStore.user.rol_level)

const updateRoleId = (role) => {
  rolesStore.itemToEdit = { ...role }
}

const deleteRoleId = async (id) => {
  try {
    await rolesStore.removeItem({ id })
  } catch (error) {
    console.log(error)
  }
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
        :subText="`Level: ${role.permission_level}`"
        :canEdit="rol_level >= 4"
        :canDelete="rol_level >= 5"
        @edit="updateRoleId(role)"
        @delete="deleteRoleId(role.id)"
      />
    </div>
  </div>
</template>
