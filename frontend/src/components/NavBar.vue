<script setup>
import { useLoginStore } from '@/stores/loginStore'
import { computed, ref } from 'vue'

const loginStore = useLoginStore()
const isMenuOpen = ref(false)

const rol_level = computed(() => parseInt(loginStore.user?.rol_level || 0))

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>

<template>
  <nav class="navbar">
    <RouterLink to="/">
      <img src="@/assets/logo.webp" alt="Logo tecnocontrol" class="img-logo" />
    </RouterLink>

    <button class="menu-toggle" @click="toggleMenu">☰</button>

    <div class="navbar__links" :class="{ open: isMenuOpen }">
      <RouterLink to="/" @click="toggleMenu">Home</RouterLink>
      <RouterLink v-if="!loginStore.logged" to="/login" @click="toggleMenu">Login</RouterLink>
      <RouterLink v-if="loginStore.logged && rol_level >= 4" to="/meposts" @click="toggleMenu"
        >Me Posts</RouterLink
      >
      <RouterLink v-if="loginStore.logged && rol_level >= 2" to="/posts" @click="toggleMenu"
        >Posts</RouterLink
      >
      <RouterLink v-if="loginStore.logged && rol_level >= 2" to="/users" @click="toggleMenu"
        >Users</RouterLink
      >
      <RouterLink v-if="loginStore.logged && rol_level >= 2" to="/roles" @click="toggleMenu"
        >Roles</RouterLink
      >
      <RouterLink
        v-if="loginStore.logged"
        @click.prevent="loginStore.logout"
        to="#"
        @click="toggleMenu"
      >
        Log out
      </RouterLink>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  padding-bottom: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #808080;
  position: relative;
}

.navbar__links {
  display: flex;
  gap: 2rem;
}

.img-logo {
  width: 120px;
}

.navbar__links a {
  font-weight: bold;
}

.menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 2rem;
  cursor: pointer;
}

@media (max-width: 650px) {
  .navbar__links {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 50%;
    right: 0;
    background-color: #1a1a1a;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .navbar__links.open {
    display: flex;
  }

  .menu-toggle {
    display: block;
    color: white;
  }
}
</style>
