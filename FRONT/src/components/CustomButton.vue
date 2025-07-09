<script setup lang="ts">
import Button from "primevue/button"

type Props = {
  label?: string,
  outline?: boolean,
  customComponent?: object,
  type?: "button" | "submit" | "reset",
  loading?: boolean,
  disabled?: boolean,
  size?: "small" | "large",
}

withDefaults(defineProps<Props>(), {outline: false, type: "button"})
</script>

<template>
  <Button
      :label="label"
      :class="outline ? 'buttonOutlined' : 'buttonFilled'"
      :variant="outline ? 'outlined' : undefined"
      :type="type"
      :loading="loading"
      :disabled="disabled"
      :size="size"
  >
    <template #icon>
      <component :is="customComponent"/>
    </template>
  </Button>
</template>