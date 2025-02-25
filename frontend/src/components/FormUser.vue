<script setup>
import { useUserStore } from '@/stores/userStore'
import { registerSchema, updateUserSchema } from '@/schemas/validateSchemas'
import BaseForm from '@/components/BaseForm.vue'
import { useRoleStore } from '@/stores/rolesStore'
import { computed } from 'vue'

const userStore = useUserStore()
const rolesStore = useRoleStore()

if (rolesStore.items.length === 0) rolesStore.loadItems()

const fields = computed(() => [
  { name: 'name', label: 'Name', type: 'text', required: true, placeholder: 'Javier' },
  { name: 'last_name', label: 'Last name', type: 'text', required: true, placeholder: 'Salazar' },
  {
    name: 'email',
    label: 'Email',
    type: 'email',
    required: true,
    placeholder: 'example@example.com',
  },
  {
    name: 'password',
    label: 'Password',
    type: 'password',
    required: true,
    placeholder: '********',
  },
  {
    name: 'rol_id',
    label: 'Role',
    type: 'select',
    required: true,
    multiple: false,
    options: rolesStore.items.map((role) => ({
      value: role.id.toString(),
      label: role.name,
    })),
  },
])

const handleSubmit = async (data) => {
  try {
    if (userStore.itemToEdit) {
      await userStore.editItem(data)
    } else {
      await userStore.addItem(data)
    }
  } catch (error) {
    console.log(error)
  }
}

const handleCancel = () => {
  userStore.itemToEdit = null
}
</script>

<template>
  <BaseForm
    title="user"
    :fields="fields"
    :store="userStore"
    :validationSchema="userStore.itemToEdit ? updateUserSchema : registerSchema"
    :entityToEdit="userStore.itemToEdit"
    @submit="handleSubmit"
    @cancel="handleCancel"
  />
</template>
