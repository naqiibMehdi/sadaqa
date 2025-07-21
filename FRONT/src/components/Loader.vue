<script setup lang="ts">
import ProgressSpinner from "primevue/progressspinner";

</script>

<template>
  <Teleport to="body">
    <div class="spinner-overlay">
      <ProgressSpinner stroke-width="5"/>
    </div>
  </Teleport>
</template>

<style scoped>
.spinner-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
</style>