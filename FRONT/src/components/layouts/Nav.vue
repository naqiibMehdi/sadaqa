<script setup lang="ts">
type Props = {
  title?: string,
  links?: ({ name: string, label: string })[],
  prefixClass?: string
}

defineProps<Props>()
</script>

<template>
  <nav :class="`nav ${prefixClass}-nav`">
    <ul :class="`nav-list ${prefixClass}-list`">
      <li class="nav-title" v-if="title"><p>{{ title }}</p></li>
      <li v-for="link in links" :key="link.name" :class="`nav-link ${prefixClass}-link`">
        <RouterLink :to="{name: link.name}">{{ link.label }}</RouterLink>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
.nav-title {
  margin-bottom: 1.25rem;
  color: var(--accent);
  font-weight: 600;
}

.nav-list li {
  list-style: none;
  margin-bottom: 1rem;
}

.nav-link a:hover {
  text-decoration: underline;
}

</style>