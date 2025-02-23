<script setup>
import BaseForm from '@/components/BaseForm.vue'
import { roleSchema } from '@/schemas/validateSchemas'
import { useRoleStore } from '@/stores/rolesStore'

const roleStore = useRoleStore()

const fields = [
  { name: 'name', label: 'Name', type: 'text', required: true, placeholder: 'Super admin' },
  {
    name: 'permission_level',
    label: 'Permission level',
    type: 'number',
    required: true,
    placeholder: '10',
  },
]

const handleSubmit = async (data) => {
  try {
    if (roleStore.itemToEdit) {
      await roleStore.editItem(data)
    } else {
      await roleStore.addItem(data)
    }
  } catch (error) {
    console.log(error)
  }
}

const handleCancel = () => {
  roleStore.itemToEdit = null
}
</script>

<template>
  <BaseForm
    title="role"
    :fields="fields"
    :store="roleStore"
    :validationSchema="roleSchema"
    :entityToEdit="roleStore.itemToEdit"
    @submit="handleSubmit"
    @cancel="handleCancel"
  />
</template>
