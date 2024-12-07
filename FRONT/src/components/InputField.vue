<script setup lang="ts">
import {InputText} from "primevue";

defineProps<{ placeholder: string }>()
</script>

<template>
  <InputText type="text" :placeholder="placeholder" :class="$style.fieldColorBorder"/>
</template>

<style scoped module>
.fieldColorBorder:enabled:focus {
  border-color: var(--primary);
}

</style>