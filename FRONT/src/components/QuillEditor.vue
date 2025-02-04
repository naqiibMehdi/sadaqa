<script setup lang="ts">
import Quill from "quill"
import "quill/dist/quill.snow.css"
import {onMounted, ref} from "vue";

let editorRef = ref("")
let quill: Quill

onMounted(() => {
  quill = new Quill(editorRef.value, {
    theme: "snow",
    modules: {
      toolbar: {
        container: ['bold', 'italic', 'underline', 'link', 'image'],
        handlers: {
          image: handleImageUpload
        }
      },
    }
  })
})

const handleImageUpload = () => {
  const input = document.createElement("input")
  input.type = "file"
  input.accept = "image/*"

  input.click()
}
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
  min-height: 300px;
  font-size: 1rem;
  background-color: #fff;
}
</style>