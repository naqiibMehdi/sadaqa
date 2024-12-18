<script setup lang="ts">
defineProps<{ title?: string, links?: string[], prefixClass?: string }>()
</script>

<template>
  <nav :class="`nav ${prefixClass}-nav`">
    <ul :class="`nav-list ${prefixClass}-list`">
      <li class="nav-title" v-if="title"><p>{{ title }}</p></li>
      <li v-for="link in links" :key="link" :class="`nav-link ${prefixClass}-link`"><a href="">{{ link }}</a></li>
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