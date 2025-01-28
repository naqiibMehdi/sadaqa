<script setup lang="ts">
import {InputText} from "primevue";


withDefaults(defineProps<{
  modelValue?: string,
  placeholder: string,
  id?: string,
  title?: string,
  size?: "small" | "large",
  invalid?: boolean | undefined | null
  type?: "text" | "number" | "password" | "email" | "url" | "tel"
}>(), {type: "text"})

const emit = defineEmits(["update:modelValue"]);
const onInput = (e: Event) => {
  const target = e.target as HTMLInputElement | null;
  if (target !== null) {
    emit("update:modelValue", target.value);
  }
}
</script>

<template>
  <div class="form-inputLabel form-inputLabel_inline">
    <label :for="id" v-if="id">{{ title }}</label>
    <InputText :type="type" :placeholder="placeholder" :class="$style.fieldColorBorder" :id="id" :size="size"
               :value="modelValue" @input="onInput" :invalid="invalid"/>
  </div>
</template>

<style scoped module>
.fieldColorBorder:enabled:focus {
  border-color: var(--primary);
}

label {
  text-transform: capitalize;
}

</style>