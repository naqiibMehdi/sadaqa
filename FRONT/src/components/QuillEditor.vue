<script setup lang="ts">
import Editor from "primevue/editor"
import "quill/dist/quill.snow.css"
import {ref, watch} from "vue";

const props = defineProps<{ modelValue: string }>()

const localContent = ref(props.modelValue)

const emit = defineEmits(['update:modelValue'])

watch(localContent, (newValue) => {
  emit('update:modelValue', newValue)
})

</script>

<template>
  <!--  <div class="quill-group">-->
  <!--    <label for="">Description</label>-->
  <!--    <div class="quill-editor">-->
  <!--      <div ref="editorRef" class="quill-container"></div>-->
  <!--    </div>-->
  <!--  </div>-->
  <div class="quill-group">
    <label for="">Description</label>
    <Editor editorStyle="height: 280px; font-size: 1rem" class="quill-editor" v-model="localContent">
      <template v-slot:toolbar>
        <span class="ql-formats">
            <button v-tooltip="'Bold'" class="ql-bold"></button>
            <button v-tooltip="'Italic'" class="ql-italic"></button>
            <button v-tooltip="'Underline'" class="ql-underline"></button>
            <button v-tooltip="'link'" class="ql-link"></button>
            <button v-tooltip="'image'" class="ql-image"></button>
        </span>
      </template>
    </Editor>
  </div>
</template>

<style scoped>

.quill-editor {
  margin-top: .9rem;
}


</style>