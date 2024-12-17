<script setup lang="ts">
import IcBaselinePhotoCamera from '~icons/ic/baseline-photo-camera'
import {ref} from "vue";

let url = ref<string>("")

</script>

<template>
  <div class="fileUploader-banner-upload">
    <input type="file" hidden="">
    <div v-if="!url" style="display: flex; flex-direction: column; align-items: center">
      <IcBaselinePhotoCamera width="32" height="32"/>
      <p>Joindre une image principale</p>
    </div>
    <div v-else class="fileUploader-banner-upload__bgImage" :style="{ backgroundImage: `url(${url})` }">

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