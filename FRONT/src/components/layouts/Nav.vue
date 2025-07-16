<script setup lang="ts">

type Props = {
  title?: string,
  links?: ({
    label: string,
    a?: string,
    to: {
      name: string,
      params?: { [key: string]: string | number | undefined }
    }
  })[],
  prefixClass?: string
}

defineProps<Props>()
</script>

<template>
  <nav :class="`nav ${prefixClass}-nav`">
    <ul :class="`nav-list ${prefixClass}-list`">
      <li class="nav-title" v-if="title"><p>{{ title }}</p></li>
      <li v-for="link in links" :key="link.to?.name" :class="`nav-link ${prefixClass}-link`">
        <a :href="link.a" target="_blank" rel="noreferrer" v-if="link.a !== ''">{{ link.label }}</a>
        <RouterLink :to="link.to" v-else>{{ link.label }}</RouterLink>
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