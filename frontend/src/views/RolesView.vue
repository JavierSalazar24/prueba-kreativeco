<script setup>
import FormRoles from '@/components/FormRoles.vue'
import RolesList from '@/components/RolesList.vue'
import { useRoles } from '@/composables/useRoles'
import { useRouter } from 'vue-router'

const router = useRouter()

const { hasPermission, logged } = useRoles()

if (!logged) router.push('/login')
else if (!hasPermission('consulta')) router.push('/')
</script>

<template>
  <div class="container">
    <FormRoles v-if="hasPermission('agregar')" />

    <RolesList v-if="hasPermission('consulta')" />
  </div>
</template>
