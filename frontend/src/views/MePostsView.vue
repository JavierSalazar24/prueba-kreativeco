<script setup>
import PostsList from '@/components/PostsList.vue'
import { useLoginStore } from '@/stores/loginStore'
import { usePostStore } from '@/stores/postStore'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const postStore = usePostStore()
const loginStore = useLoginStore()
const router = useRouter()

const rol_level = parseInt(loginStore.user.rol_level)

if (!loginStore.logged) router.push('/login')
else if (rol_level < 2) router.push('/')

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
