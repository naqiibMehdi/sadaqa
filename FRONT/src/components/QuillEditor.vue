<script setup lang="ts">
import Quill from "quill"
import "quill/dist/quill.snow.css"
import {onMounted, ref} from "vue";

let editor = ref<any | Quill>(null)
let editorRef = ref("")


onMounted(() => {
  editor.value = new Quill(editorRef.value, {
    theme: "snow",
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline', 'link', 'image'],
      ]
    }
  })
  editor.value.root.style.fontSize = "1rem"
})
</script>

<template>
  <div class="quill-group">
    <label for="">Description</label>
    <div class="quill-editor">
      <div ref="editorRef" class="quill-container"></div>
    </div>
  </div>
</template>

<style scoped>
.quill-editor {
  margin-top: .9rem;
}

.quill-container {
  min-height: 150px;
  background-color: #fff;
}
</style>