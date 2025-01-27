<script setup lang="ts">
import Button from "primevue/button"


withDefaults(defineProps<{
  label: string,
  outline?: boolean,
  customComponent?: object,
  type: "button" | "submit" | "reset",
  loading?: boolean,
}>(), {outline: false, type: "button"})
</script>

<template>
  <Button :label="label" :class="outline ? 'buttonOutlined' : 'buttonFilled'"
          :variant="outline ? 'outlined' : undefined" :type="type" :loading="loading">
    <template #icon>
      <component :is="customComponent"/>
    </template>
  </Button>
</template>