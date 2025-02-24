<script setup>
import DashboardActions from '@/components/DashboardActions.vue'
import DashboardStats from '@/components/DashboardStats.vue'
import LoaderCard from '@/components/LoaderCard.vue'
import { useLoginStore } from '@/stores/loginStore'
import { usePostStore } from '@/stores/postStore'
import { useRoleStore } from '@/stores/rolesStore'
import { useUserStore } from '@/stores/userStore'
import { computed, watchEffect } from 'vue'

const loginStore = useLoginStore()
const postStore = usePostStore()
const userStore = useUserStore()
const roleStore = useRoleStore()

const rol_level = parseInt(loginStore.user.rol_level)

watchEffect(() => {
  if (loginStore.logged && rol_level >= 2) {
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
      <h1>Welcome, {{ `${loginStore.user.name} ${loginStore.user.last_name}` || 'new user' }}!</h1>
      <p class="subtitle">
        {{ subtitle }}
      </p>

      <div v-if="loginStore.logged && rol_level >= 2">
        <template v-if="postStore.loading || userStore.loading || roleStore.loading">
          <LoaderCard />
        </template>
        <template v-else>
          <DashboardStats :stats="stats" />
          <DashboardActions />
        </template>
      </div>
      <div class="not-access" v-else>
        <p>You do not have permissions to request the information, only to access.</p>
      </div>
    </section>
  </main>
</template>

<style scoped>
.welcome-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 2rem;
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
  text-align: center;
  color: #e21e60;
  margin-bottom: 2rem;
  font-size: 35px;
  margin-top: 0;
}

.subtitle {
  text-align: center;
  color: #a0aec0;
  margin-bottom: 2rem;
}

.not-access {
  text-align: center;
  margin: 0;
}

@media (max-width: 550px) {
  .welcome-container {
    padding: 0;
  }
}

@media (max-width: 380px) {
  h1 {
    font-size: 25px;
  }
  .subtitle {
    font-size: 15px;
  }
}
</style>
