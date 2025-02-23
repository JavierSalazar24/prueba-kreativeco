<script setup>
import PostsList from '@/components/PostsList.vue'
import { useLoginStore } from '@/stores/loginStore'
import { usePostStore } from '@/stores/postStore'
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const postStore = usePostStore()
const loginStore = useLoginStore()
const router = useRouter()

if (!loginStore.logged) router.push('/login')

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
