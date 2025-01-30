<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
</script>

<template>
  <Header/>
  <Main>
    <div class="form-container">
      <h1 class="forget-pwd-title">Vous avez oublié votre mot de passe ?</h1>
      <p class="forget-pwd-text">Saisissez votre email afin de recevoir un email permettant de réinitialiser votre mot
        de
        passe.</p>
      <InputField placeholder="Email"/>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Valider"/>
      </div>
    </div>
  </Main>
  <Footer/>
</template>

<style scoped>

.formConnexion-buttons-list {
  display: flex;
  flex-direction: column;
  row-gap: 1rem;
}

.forget-pwd-title {
  text-align: center;
}

.formConnexion-buttons-list button {
  width: 100%;
  font-size: 1.125rem;
}
</style>