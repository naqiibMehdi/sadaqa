<script setup lang="ts">
defineProps<{ icon: string, color: string }>()
</script>

<template>
  <i :class="`pi pi-${icon}`" :style="{color}"></i>
</template>

<style scoped>

</style>