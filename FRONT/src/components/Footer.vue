<script setup lang="ts">

import Nav from "@/components/Nav.vue";
import Icon from "@/components/Icon.vue";
</script>

<template>
  <footer class="footer">
    <div class="container">
      <p class="footer-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
        ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat.
      </p>
      <div class="footer-nav">
        <Nav title="Ressource"/>
        <Nav title="A Propos"/>
        <Icon icon="twitter" color="blue"/>
      </div>
    </div>
  </footer>
</template>

<style scoped>
footer {
  background-color: var(--text5);
  display: flex;
  justify-content: center;
  padding: 1.5rem 0;
}

.footer-text {
  margin-bottom: 0.85rem
}

.footer-nav {
  display: flex;
  align-items: flex-start;
  justify-content: space-around;
}
</style>