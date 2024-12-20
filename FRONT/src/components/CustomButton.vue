<script setup lang="ts">
import Button from "primevue/button"


withDefaults(defineProps<{ label: string, outline?: boolean, customComponent?: object }>(), {outline: false})
</script>

<template>
  <Button :label="label" :class="outline ? 'buttonOutlined' : 'buttonFilled'"
          :variant="outline ? 'outlined' : undefined">
    <template #icon>
      <component :is="customComponent"/>
    </template>
  </Button>
</template>