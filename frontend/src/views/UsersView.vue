<script setup>
import FormUser from '@/components/FormUser.vue'
import UsersList from '@/components/UsersList.vue'
import { useRoles } from '@/composables/useRoles'
import { useRouter } from 'vue-router'

const router = useRouter()

const { hasPermission, logged } = useRoles()

if (!logged) router.push('/login')
else if (!hasPermission('consulta')) router.push('/')
</script>

<template>
  <div class="container">
    <FormUser v-if="hasPermission('agregar')" />

    <UsersList v-if="hasPermission('consulta')" />
  </div>
</template>
