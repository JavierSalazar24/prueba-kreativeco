<script setup>
defineProps({
  title: String,
  description: String,
  subText: String,
  littleSubText: String,
  canEdit: Boolean,
  canDelete: Boolean,
  store: Object,
})
</script>

<template>
  <div class="card">
    <h3>{{ title }}</h3>
    <p v-if="description" class="card-text">{{ description }}</p>
    <p v-if="subText" class="card-sub-text">{{ subText }}</p>
    <p v-if="littleSubText" class="card-little-sub-text">{{ littleSubText }}</p>
    <div class="buttons-actions">
      <button
        class="edit"
        @click="$emit('edit')"
        v-if="canEdit"
        :disabled="store.loadingFetch || store.loadingDelete"
      >
        Edit
      </button>
      <button
        class="delete"
        @click="$emit('delete')"
        v-if="canDelete"
        :disabled="store.loadingFetch || store.loadingDelete"
      >
        {{ store.loadingDelete ? 'Deleting...' : 'Delete' }}
      </button>
    </div>
  </div>
</template>
