<script setup>
import FormPosts from '@/components/FormPosts.vue'
import PostsList from '@/components/PostsList.vue'
import { useRoles } from '@/composables/useRoles'
import { usePostStore } from '@/stores/postStore'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const postStore = usePostStore()
const router = useRouter()

const { hasPermission, logged } = useRoles()

if (!logged) router.push('/login')
else if (!hasPermission('consulta')) router.push('/')

onMounted(() => {
  postStore.resetStore()
  postStore.loadItems()
})
</script>

<template>
  <div class="container">
    <FormPosts v-if="hasPermission('agregar')" />

    <PostsList v-if="hasPermission('consulta')" />
  </div>
</template>
