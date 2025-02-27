<script setup>
import Swal from 'sweetalert2'
import { usePostStore } from '@/stores/postStore'
import { formatDate } from '@/utils/formatDate'
import { useRoles } from '@/composables/useRoles'
import LoaderCard from './LoaderCard.vue'
import EmptyCard from './EmptyCard.vue'
import CardBase from './CardBase.vue'

const postStore = usePostStore()

const { hasPermission } = useRoles()

const updatePostId = (post) => {
  postStore.itemToEdit = { ...post }
}

const deletePostId = async (id) => {
  Swal.fire({
    title: 'Are you sure to remove it?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then(async (result) => {
    try {
      if (result.isConfirmed) await postStore.removeItem(id)
    } catch (error) {
      console.log(error)
    }
  })
}
</script>

<template>
  <div class="container-list">
    <h2>Posts</h2>

    <LoaderCard v-if="postStore.loading" />
    <EmptyCard v-else-if="postStore.items.length === 0" />
    <div v-else class="cards-container">
      <CardBase
        v-for="post in postStore.items"
        :key="post.id"
        :title="post.title"
        :description="post.description"
        :subText="`By: ${post.author} (${post.name})`"
        :littleSubText="`Created on: ${formatDate(post.date_created)}`"
        :canEdit="hasPermission('actualizar') && !postStore.mePosts"
        :canDelete="hasPermission('eliminar') && !postStore.mePosts"
        :store="postStore"
        @edit="updatePostId(post)"
        @delete="deletePostId(post.id)"
      />
    </div>
  </div>
</template>
