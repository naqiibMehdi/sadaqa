<script setup lang="ts">
import {InputText} from "primevue";


defineProps<{ placeholder: string, id?: string, title?: string }>()
</script>

<template>
  <label :for="id" v-if="id">{{ title }}</label>
  <InputText type="text" :placeholder="placeholder" :class="$style.fieldColorBorder" :id="id"/>
</template>

<style scoped module>
.fieldColorBorder:enabled:focus {
  border-color: var(--primary);
}

label {
  text-transform: capitalize;
}

</style>