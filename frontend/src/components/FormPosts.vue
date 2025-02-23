<script setup>
import { usePostStore } from '@/stores/postStore'
import { postSchema } from '@/schemas/validateSchemas'
import BaseForm from '@/components/BaseForm.vue'

const postStore = usePostStore()

const fields = [
  {
    name: 'title',
    label: 'Title',
    type: 'text',
    required: true,
    placeholder: 'Aprende Vue rápido',
  },
  {
    name: 'description',
    label: 'Description',
    type: 'textarea',
    required: true,
    placeholder: 'Con estos consejos dominarás Vue rápidamente...',
  },
]

const handleSubmit = async (data) => {
  try {
    if (postStore.itemToEdit) {
      await postStore.editItem(data)
    } else {
      await postStore.addItem(data)
    }
  } catch (error) {
    console.log(error)
  }
}

const handleCancel = () => {
  postStore.itemToEdit = null
}
</script>

<template>
  <BaseForm
    title="post"
    :fields="fields"
    :store="postStore"
    :validationSchema="postSchema"
    :entityToEdit="postStore.itemToEdit"
    @submit="handleSubmit"
    @cancel="handleCancel"
  />
</template>
