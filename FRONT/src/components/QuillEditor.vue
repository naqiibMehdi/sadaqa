<script setup lang="ts">
import Quill, {Range} from "quill"
import "quill/dist/quill.snow.css"
import {onMounted, ref} from "vue";
import {postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";

let editorRef = ref("")
let quill: Quill | null

onMounted(() => {
  quill = new Quill(editorRef.value, {
    theme: "snow",
    modules: {
      toolbar: {
        container: [
          ['bold', 'italic', 'underline', 'link', 'image']
        ],
        handlers: {
          image: handleImageUpload,
        }
      },
    }
  })
  quill?.root.addEventListener("keydown", deleteImage)
})

const deleteImage = (e: KeyboardEvent) => {
  if (e.key === "Delete" || e.key === "Backspace") {
    console.log(e)
  }
}
const handleImageUpload = () => {
  const input = document.createElement("input")
  input.type = "file"
  input.accept = "image/*"
  input.click()

  input.onchange = async (e: Event) => {
    const file = (e.target as HTMLInputElement)?.files?.[0]
    if (file) {
      try {
        const response = await postMultiPartData("upload-image", {image: file})
        const range = quill?.getSelection() as Range
        quill?.insertEmbed(range.index, "image", response.url)
        quill?.setSelection(range.index + 1, 0)

      } catch (e) {
        if (e instanceof AxiosError) {
          console.log("erreur", e?.response?.data)

        }
      }
    }
  }
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