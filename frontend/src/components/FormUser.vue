<script setup>
import { useUserStore } from '@/stores/userStore'
import { registerSchema, updateUserSchema } from '@/schemas/validateSchemas'
import BaseForm from '@/components/BaseForm.vue'

const userStore = useUserStore()

const fields = [
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
    options: [
      { value: '1', label: 'Rol básico' },
      { value: '2', label: 'Rol medio' },
      { value: '3', label: 'Rol medio alto' },
      { value: '4', label: 'Rol alto medio' },
      { value: '5', label: 'Rol alto' },
    ],
  },
]

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
