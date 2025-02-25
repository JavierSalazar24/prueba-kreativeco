<script setup>
import PostsList from '@/components/PostsList.vue'
import { useRoles } from '@/composables/useRoles'
import { usePostStore } from '@/stores/postStore'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const postStore = usePostStore()
const router = useRouter()

const { hasPermission, logged } = useRoles()

if (!logged) router.push('/login')
else if (!hasPermission('agregar')) router.push('/')

onMounted(() => {
  postStore.resetStore()
  postStore.loadMePosts()
})
</script>

<template>
  <div class="container">
    <PostsList />
  </div>
</template>
