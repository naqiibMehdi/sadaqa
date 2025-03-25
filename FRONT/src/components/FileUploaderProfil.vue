<script setup lang="ts">


</script>

<template>
  <div class="fileUploaderProfil-banner-upload">
    <input type="file" hidden="">
    <p class="fileUploaderProfil-button" role="button">Modifier</p>
  </div>
</template>

<style scoped>
.fileUploaderProfil-banner-upload {
  position: relative;
  width: 100%;
  height: 200px;
  border: 2px solid var(--text5);
  display: flex;
  flex-direction: column;
  justify-content: end;
  align-items: center;
  background-image: url("https://placehold.co/600x400");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.fileUploaderProfil-button {
  margin-bottom: 1rem;
  background-color: var(--text50);
  color: #fff;
  padding: 5px 10px;
  border-radius: 10px;
}

</style>