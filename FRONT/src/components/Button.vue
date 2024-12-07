<script setup lang="ts">
import Button from "primevue/button"

withDefaults(defineProps<{ label: string, outline: boolean }>(), {outline: false})
</script>

<template>
  <Button :label="label" :class="outline ? $style.buttonOutlined : $style.buttonFilled"
          :variant="outline ? 'outlined' : undefined"/>
</template>

<style scoped module>
.buttonFilled {
  background-color: var(--primary);
  border: none;
}

.buttonOutlined {
  color: var(--background);
}

.buttonFilled:not(:disabled):hover {
  background-color: var(--accent);
  border: none;
}

.buttonOutlined {
  border-color: var(--primary);
}

.buttonOutlined:not(:disabled):hover {
  border-color: var(--primary);
  background-color: var(--background-90);
}
</style>