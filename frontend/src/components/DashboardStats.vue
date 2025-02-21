<script setup>
defineProps({
  stats: Array,
})
</script>

<template>
  <section class="sections">
    <article v-for="(stat, index) in stats" :key="index" class="section-item">
      <h3>{{ stat.title }}</h3>
      <p>{{ stat.count }}</p>
    </article>
  </section>
</template>

<style scoped>
.sections {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.section-item {
  text-align: center;
  flex: 1;
}

.section-item h3 {
  color: #a0aec0;
  margin-bottom: 0.5rem;
}

.section-item p {
  font-size: 1.5rem;
  font-weight: bold;
}

@media (max-width: 600px) {
  .sections {
    flex-direction: column;
  }

  .section-item {
    margin-bottom: 1rem;
  }
}
</style>
