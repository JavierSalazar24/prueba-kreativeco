<script setup>
import FormRoles from '@/components/FormRoles.vue'
import RolesList from '@/components/RolesList.vue'
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
    <FormRoles v-if="rol_level >= 3" />

    <RolesList />
  </div>
</template>
