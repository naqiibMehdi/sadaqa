<script setup lang="ts">
import Quill, {Range} from "quill"
import "quill/dist/quill.snow.css"
import {onMounted, ref, watch} from "vue";
import {postData, postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import {useToast} from "primevue/usetoast";

const props = defineProps<{ modelValue: HTMLElement | string | undefined }>()
const emit = defineEmits(["update:modelValue"]);

const toast = useToast();

let selectedImage = ref<HTMLImageElement | null>(null)
let errorsUploadImage = ref<string[]>([])
let editorContainer = ref<HTMLDivElement | string>("")
let quill: Quill | null


onMounted(() => {
  quill = new Quill(editorContainer.value, {
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

  quill?.root.addEventListener("keydown", handleDeleteImage)
  quill?.root.addEventListener("click", handleImageSelection)
  quill?.on("text-change", () => {
    const content = quill?.root.innerHTML
    emit("update:modelValue", content)
  })

  if (props.modelValue) {
    quill.clipboard.dangerouslyPasteHTML(props.modelValue as string)
    const editorLength = quill.getLength()
    quill.setSelection(editorLength, 0)
  }
})

watch(() => props.modelValue, (newValue) => {
  if (newValue !== undefined && quill) {
    quill.clipboard.dangerouslyPasteHTML(newValue as string);
    const editorLength = quill.getLength();
    quill.setSelection(editorLength, 0);
  }
});

const handleImageSelection = (e: Event) => {
  const target = e.target as HTMLImageElement

  if (target.tagName === "IMG") {
    selectedImage.value = target
  } else {
    selectedImage.value = null
  }
}

const handleDeleteImage = async (e: KeyboardEvent) => {
  if (selectedImage.value && (e.key === "Backspace" || e.key === "Delete")) {
    try {
      await postData("delete-image", {url: selectedImage.value?.src})
      selectedImage.value = null
    } catch (e) {
      console.error(e)
    }
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
      errorsUploadImage.value = []
      try {
        const response = await postMultiPartData("upload-image", {image: file})
        const range = quill?.getSelection() as Range
        quill?.insertEmbed(range.index, "image", response.url)
        quill?.setSelection(range.index + 1, 0)

      } catch (e) {
        if (e instanceof AxiosError) {
          errorsUploadImage.value = e.response?.data?.errors?.image
          toast.add({
            severity: 'error',
            summary: 'Erreurs',
            detail: errorsUploadImage.value.join("\n"),
            life: 5000,
          });

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
      <div ref="editorContainer" class="quill-container"></div>
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