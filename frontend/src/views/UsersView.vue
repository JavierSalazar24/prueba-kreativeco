<script setup>
import FormUser from '@/components/FormUser.vue'
import UsersList from '@/components/UsersList.vue'
import { useLoginStore } from '@/stores/loginStore'
import { useRouter } from 'vue-router'

const loginStore = useLoginStore()
const router = useRouter()

const rol_level = parseInt(loginStore.user.rol_level)

if (!loginStore.logged) router.push('/login')
else if (rol_level < 2) router.push('/')
</script>

<template>
  <div class="container">
    <FormUser v-if="rol_level >= 3" />

    <UsersList />
  </div>
</template>
