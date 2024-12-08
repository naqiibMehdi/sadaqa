<script setup lang="ts">

</script>

<template>
  <main class="main">
    <slot></slot>
  </main>
</template>

<style scoped>
.main {
  min-height: 100svh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

</style>