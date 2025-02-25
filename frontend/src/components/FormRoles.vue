<script setup>
import BaseForm from '@/components/BaseForm.vue'
import { roleSchema } from '@/schemas/validateSchemas'
import { useRoleStore } from '@/stores/rolesStore'

const roleStore = useRoleStore()

const fields = [
  { name: 'name', label: 'Name', type: 'text', required: true, placeholder: 'Super admin' },
  {
    name: 'permissions',
    label: 'Permissions',
    type: 'select',
    required: true,
    multiple: true,
    options: [
      { label: 'Acceso', value: 'acceso' },
      { label: 'Consulta', value: 'consulta' },
      { label: 'Agregar', value: 'agregar' },
      { label: 'Actualizar', value: 'actualizar' },
      { label: 'Eliminar', value: 'eliminar' },
    ],
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
