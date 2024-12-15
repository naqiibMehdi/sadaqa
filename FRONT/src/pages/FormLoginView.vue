<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
</script>

<template>
  <Header/>
  <Main>
    <div class="formConnexion-container">
      <InputField placeholder="Email"/>
      <InputField placeholder="Mot de passe"/>
      <a class="formConnexion-text" href="">Mot de passe oublié ?</a>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Connexion"/>
        <CustomButton label="S'inscrire" :outline="true"/>
      </div>
    </div>
  </Main>
  <Footer/>
</template>

<style scoped>

.formConnexion-container {
  display: flex;
  flex-direction: column;
  row-gap: 1.3rem;
  width: calc(100% / 2);
  max-width: 700px;
}

.formConnexion-buttons-list {
  display: flex;
  flex-direction: column;
  row-gap: 1rem;
}

.formConnexion-text {
  font-size: 0.9rem;
  text-align: right;
}

.formConnexion-text:hover {
  text-decoration: underline;
  color: var(--accent);
}

.formConnexion-buttons-list custom-button {
  width: 100%;
}
</style>