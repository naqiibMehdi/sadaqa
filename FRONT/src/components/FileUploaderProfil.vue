<script setup lang="ts">
import IcBaselineDelete from '~icons/ic/baseline-delete'
import IcBaselineEdit from '~icons/ic/baseline-edit'
import {ref} from "vue";
import {useToast} from "primevue/usetoast";

interface Props {
  imageProfile: string
}

defineProps<Props>()


const toast = useToast()

const urlBase64 = ref<string | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

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
        detail: "Vous pouver seulement joindre un fichier image à votre photo de profile",
        life: 5000
      });
      return
    }
    convertToBase64(file)
    //emit('update:modelValue', file)
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
  //emit('update:modelValue', "")
}
</script>

<template>
  <div class="fileUploaderProfil">
    <input type="file" hidden="" ref="fileInput" @change="handleFileChange">
    <img :src="urlBase64 || imageProfile" alt="image de profile" class="fileUploaderProfil-banner-upload"/>
    <div class="fileUploaderProfil-button-list">
      <IcBaselineEdit width="40" height="40" class="icon-edit" @click="triggerFileInput"/>
      <IcBaselineDelete width="40" height="40" class="icon-delete" @click="deleteUrlBase64"/>
    </div>
  </div>
</template>

<style scoped>
.fileUploaderProfil {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .8rem;
}

.fileUploaderProfil-banner-upload {
  width: 150px;
  height: 150px;
  border-radius: 50%;
}

.fileUploaderProfil-button-list {
  display: flex;
  gap: .8rem;
}

.icon-edit {
  color: white;
  background-color: green;
}

.icon-delete {
  color: white;
  background-color: darkred;
}

.icon-delete, .icon-edit {
  border-radius: 10px;
  padding: .3rem;
}

.icon-edit:hover, .icon-delete:hover {
  cursor: pointer;
}
</style>