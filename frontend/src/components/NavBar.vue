<script setup>
import { useRoles } from '@/composables/useRoles'
import { ref } from 'vue'

const isMenuOpen = ref(false)

const { hasPermission, logged, logout } = useRoles()

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
      <RouterLink v-if="!logged" to="/login" @click="toggleMenu">Login</RouterLink>
      <RouterLink v-if="logged && hasPermission('agregar')" to="/meposts" @click="toggleMenu"
        >Me Posts</RouterLink
      >
      <RouterLink v-if="logged && hasPermission('consulta')" to="/posts" @click="toggleMenu"
        >Posts</RouterLink
      >
      <RouterLink v-if="logged && hasPermission('consulta')" to="/users" @click="toggleMenu"
        >Users</RouterLink
      >
      <RouterLink v-if="logged && hasPermission('consulta')" to="/roles" @click="toggleMenu"
        >Roles</RouterLink
      >
      <RouterLink v-if="logged" @click.prevent="logout" to="#" @click="toggleMenu">
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
