<script setup lang="ts">
import IcBaselineDelete from '~icons/ic/baseline-delete'
import IcBaselineEdit from '~icons/ic/baseline-edit'
import {ref} from "vue";

interface Props {
  imageProfile: string,
  disabled: boolean
}

defineProps<Props>()

const urlBase64 = ref<string | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)
const imageFile = defineModel()

const triggerFileInput = () => {
  fileInput.value?.click()
}
const handleFileChange = (e: Event) => {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0]

  if (file) {
    convertToBase64(file)
    imageFile.value = file
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
  imageFile.value = ""
}
</script>

<template>
  <div class="fileUploaderProfil">
    <input type="file" hidden="" ref="fileInput" @change="handleFileChange" aria-label="joindre une image de profile">
    <img :src="imageFile ? urlBase64 as string : imageProfile" alt="image de profile"
         class="fileUploaderProfil-banner-upload"/>
    <div class="fileUploaderProfil-button-list">
      <IcBaselineEdit width="40" height="40" class="icon-edit" @click="triggerFileInput" v-if="!disabled"
                      aria-label="modifier l'image de profile"/>
      <IcBaselineDelete width="40" height="40" class="icon-delete" @click="deleteUrlBase64" v-if="imageFile"
                        aria-label="supprimer l'image de profile"/>
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
  object-fit: cover;
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