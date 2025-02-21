<script setup>
import DashboardActions from '@/components/DashboardActions.vue'
import DashboardStats from '@/components/DashboardStats.vue'
import { useLoginStore } from '@/stores/loginStore'
import { usePostStore } from '@/stores/postStore'
import { useRoleStore } from '@/stores/rolesStore'
import { useUserStore } from '@/stores/userStore'
import { computed, watchEffect } from 'vue'

const loginStore = useLoginStore()
const postStore = usePostStore()
const userStore = useUserStore()
const roleStore = useRoleStore()

watchEffect(() => {
  if (loginStore.logged) {
    userStore.loadItems()
    postStore.loadItems()
    roleStore.loadItems()
  }
})
const stats = computed(() => [
  { title: 'Posts', count: postStore.items.length },
  { title: 'Users', count: userStore.items.length },
  { title: 'Roles', count: roleStore.items.length },
])

const subtitle = computed(() =>
  loginStore.logged
    ? "It's great to see you again."
    : 'You need to log in to see the information...',
)
</script>

<template>
  <main class="welcome-container">
    <section class="welcome-panel">
      <h1>Welcome, {{ loginStore.user.name || 'new user' }}!</h1>
      <p class="subtitle">
        {{ subtitle }}
      </p>

      <div v-if="loginStore.logged">
        <DashboardStats :stats="stats" />
        <DashboardActions />
      </div>
    </section>
  </main>
</template>

<style scoped>
.welcome-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  font-family: Arial, sans-serif;
  color: #ffffff;
  padding: 0 2rem;
}

.welcome-panel {
  background-color: #18181a;
  padding: 2rem;
  border-radius: 8px;
  width: 100%;
  max-width: 800px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #e21e60;
  margin-bottom: 0.5rem;
  font-size: 35px;
  margin-top: 0;
}

.subtitle {
  color: #a0aec0;
  margin-bottom: 2rem;
}
</style>
