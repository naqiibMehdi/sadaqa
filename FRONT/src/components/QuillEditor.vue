<script setup lang="ts">
import Editor from "primevue/editor"
import "quill/dist/quill.snow.css"


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
    <Editor editorStyle="height: 180px; font-size: 1rem" class="quill-editor">
      <template v-slot:toolbar>
            <span class="ql-formats">
                <button v-tooltip.bottom="'Bold'" class="ql-bold"></button>
                <button v-tooltip.bottom="'Italic'" class="ql-italic"></button>
                <button v-tooltip.bottom="'Underline'" class="ql-underline"></button>
                <button v-tooltip.bottom="'link'" class="ql-link"></button>
                <button v-tooltip.bottom="'image'" class="ql-image"></button>
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