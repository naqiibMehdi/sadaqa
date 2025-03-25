<script setup lang="ts">

import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
</script>

<template>
  <section class="profil">
    <div class="profil-image">
      <FileUploaderProfil/>
    </div>
    <form class="form-container profil-form">
      <div class="form-inline">
        <InputField placeholder="Nom" id="nom" title="nom"/>
        <InputField placeholder="Prénom" id="prenom" title="prénom"/>
      </div>
      <InputField placeholder="example@gmail.com" id="email" title="Adresse email"/>
      <InputField placeholder="06 00 00 00 00" id="borncountry" title="Numéro de téléphone"/>
      <InputField placeholder="date naissance" id="email" title="Date de naissance"/>
      <CustomButton label="Modifier mon profil"/>
    </form>
  </section>
</template>

<style scoped>

.profil {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.profil-image {
  width: 220px;
}

.profil-form {
  width: 100%;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>