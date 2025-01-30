<script setup lang="ts">
import IcBaselinePhotoCamera from '~icons/ic/baseline-photo-camera'
import {ref} from "vue";
import {useToast} from "primevue/usetoast";

const toast = useToast()

const urlBase64 = ref<string | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

defineProps<{ modelValue: File | string }>()
const emit = defineEmits(['update:modelValue'])
const triggerFileInput = () => {
  fileInput.value?.click()
}

const handleFileChange = (e: Event) => {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0]

  if (file) {
    if (!["image/png", "image/jpeg", "image/webp", "image/jpg"].includes(file.type)) {
      toast.add({
        severity: 'error',
        summary: "Message d'erreur",
        detail: "Vous pouver seulement joindre des fichiers images à votre cagnotte",
        life: 5000
      });
      return
    }
    convertToBase64(file)
    emit('update:modelValue', file)
  }
}

const convertToBase64 = (file: File) => {
  const reader = new FileReader()

  reader.onloadend = () => {
    urlBase64.value = reader.result as string
  }
  reader.readAsDataURL(file)
}
</script>

<template>
  <div class="fileUploader-banner-upload" @click="triggerFileInput">
    <input type="file" hidden="" ref="fileInput" @change="handleFileChange">
    <div v-if="!urlBase64" style="display: flex; flex-direction: column; align-items: center">
      <IcBaselinePhotoCamera width="32" height="32"/>
      <p>Joindre une image principale</p>
    </div>
    <div v-else class="fileUploader-banner-upload__bgImage" :style="{ backgroundImage: `url(${urlBase64})` }">

    </div>
  </div>
</template>

<style scoped>
.fileUploader-banner-upload {
  position: relative;
  height: 200px;
  border: 5px solid var(--text5);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 0.3rem;
}

.fileUploader-banner-upload__bgImage {
  position: absolute;
  content: "";
  inset: 0;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.fileUploader-banner-upload:hover {
  cursor: pointer;
  background-color: var(--text5);
}
</style>