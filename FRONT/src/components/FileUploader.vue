<script setup lang="ts">
import IcBaselinePhotoCamera from '~icons/ic/baseline-photo-camera'
import IcBaselineDelete from '~icons/ic/baseline-delete'
import {onMounted, ref} from "vue";
import {useToast} from "primevue/usetoast";

const toast = useToast()

const urlBase64 = ref<string | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

const props = defineProps<{ modelValue: File | string | undefined, mainImage?: string | null }>()
const emit = defineEmits(['update:modelValue'])

onMounted(() => {
  urlBase64.value = props.mainImage ? props.mainImage : null
})

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

const deleteUrlBase64 = () => {
  urlBase64.value = null
  emit('update:modelValue', "")
}
</script>

<template>
  <div class="fileUploader-banner-upload" @click="triggerFileInput">
    <input type="file" hidden="" ref="fileInput" @change="handleFileChange" aria-label="joindre une image principale">
    <div v-if="!urlBase64" class="emptyPicture">
      <IcBaselinePhotoCamera width="32" height="32"/>
      <p>Joindre une image principale</p>
    </div>
    <div v-else class="fileUploader-banner-upload__bgImage" :style="{ backgroundImage: `url(${urlBase64})` }"
         @click.stop>
      <IcBaselineDelete width="32" height="32" class="icon-delete" @click="deleteUrlBase64"/>
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

.emptyPicture {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.fileUploader-banner-upload__bgImage {
  position: absolute;
  content: "";
  inset: 0;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.icon-delete {
  position: absolute;
  bottom: 1rem;
  right: 1rem;
  color: white;
  background-color: darkred;
  padding: 0.2rem;
  opacity: 1;
}

.icon-delete:hover {
  cursor: pointer;
}

.fileUploader-banner-upload:has(.emptyPicture):hover {
  cursor: pointer;
  background-color: var(--text5);
}
</style>