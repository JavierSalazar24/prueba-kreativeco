<script setup>
import { defineProps, defineEmits } from 'vue'
import { useFormHandler } from '@/composables/useFormHandler'
import LoaderForm from './LoaderForm.vue'

const props = defineProps({
  title: String,
  fields: Array,
  store: Object,
  validationSchema: Object,
  entityToEdit: Object,
})

const emit = defineEmits(['submit', 'cancel'])
const { form, errorsMessage, handleSubmit, handleCancel, formTitle } = useFormHandler(props, emit)
</script>

<template>
  <section class="form-section">
    <div class="form-content-title">
      <h2>{{ formTitle }}</h2>
      <LoaderForm v-if="store.loadingFetch" />
    </div>
    <form @submit.prevent="handleSubmit" autocomplete="off">
      <div v-for="field in fields" :key="field.name" class="form-group">
        <label :for="field.name">{{ field.label }}</label>

        <input
          v-if="field.type !== 'textarea' && field.type !== 'select'"
          :type="field.type"
          :id="field.name"
          :name="field.name"
          v-model="form[field.name]"
          :required="field.type === 'password' && entityToEdit ? false : field.required"
          :placeholder="field.placeholder"
          :disabled="store.loadingFetch"
        />

        <textarea
          v-else-if="field.type === 'textarea'"
          :id="field.name"
          :name="field.name"
          v-model="form[field.name]"
          :placeholder="field.placeholder"
          :disabled="store.loadingFetch"
        ></textarea>

        <select
          v-else-if="field.type === 'select'"
          :id="field.name"
          :name="field.name"
          v-model="form[field.name]"
          :required="field.required"
          :disabled="store.loadingFetch"
          :multiple="field.multiple"
        >
          <option v-for="option in field.options" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>

        <span class="error-message" v-if="errorsMessage[field.name]">
          {{ errorsMessage[field.name] }}
        </span>
      </div>

      <div class="content-buttons">
        <button
          type="submit"
          class="button button-publish"
          :disabled="store.loadingFetch || store.loadingDelete"
        >
          {{ entityToEdit ? 'Update' : 'Publish' }}
        </button>
        <button
          @click="handleCancel"
          v-if="entityToEdit"
          class="button button-cancel"
          :disabled="store.loadingFetch || store.loadingDelete"
        >
          Cancel
        </button>
      </div>
    </form>
  </section>
</template>
