<script setup>
import { useUserStore } from '@/stores/userStore'
import LoaderCard from './LoaderCard.vue'
import { useLoginStore } from '@/stores/loginStore'
import EmptyCard from './EmptyCard.vue'
import CardBase from './CardBase.vue'

const loginStore = useLoginStore()
const userStore = useUserStore()

const rol_level = parseInt(loginStore.user.rol_level)

const updateUserId = (user) => {
  userStore.itemToEdit = { ...user }
}

const deleteUserId = async (id) => {
  try {
    await userStore.removeItem({ id })
  } catch (error) {
    console.log(error)
  }
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
        :subText="`Permissions: ${user.name_rol} (Level ${user.permission_level})`"
        :canEdit="rol_level >= 4"
        :canDelete="rol_level >= 5"
        @edit="updateUserId(user)"
        @delete="deleteUserId(user.id)"
      />
    </div>
  </div>
</template>
