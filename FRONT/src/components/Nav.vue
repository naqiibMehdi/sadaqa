<script setup lang="ts">
withDefaults(defineProps<{ title: string }>(), {title: "Ressource"})
</script>

<template>
  <nav class="nav">
    <ul class="nav-list">
      <li class="nav-title"><p>{{ title }}</p></li>
      <li class="nav-link"><a href="">Ressource 1</a></li>
      <li class="nav-link"><a href="">Ressource 2</a></li>
    </ul>
  </nav>
</template>

<style scoped>
.nav-list li {
  list-style: none;
}

.nav-title {
  margin-bottom: 1.25rem;
}

</style>