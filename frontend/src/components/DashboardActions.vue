<template>
  <section class="actions">
    <h2>Quick Actions</h2>
    <div class="action-buttons">
      <RouterLink to="/posts" class="action-btn"> View posts </RouterLink>
      <RouterLink to="/users" class="action-btn"> View users </RouterLink>
      <RouterLink to="/roles" class="action-btn"> View roles </RouterLink>
    </div>
  </section>
</template>

<style scoped>
.actions {
  margin-top: 2rem;
}

.action-buttons {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.action-btn {
  padding: 0.75rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
  color: white;
  background-color: #b30545;
}

.action-btn:hover {
  background-color: #9b053c;
}

@media (max-width: 600px) {
  .action-buttons {
    grid-template-columns: 1fr;
  }
}
</style>
