<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
import Textarea from "primevue/textarea";

</script>

<template>
  <Header/>
  <Main>
    <h1 class="formContact-title">Nous contacter</h1>
    <p class="formContact-text">Vous avez une question ? Remplissez le formulaire ci-dessous et nous vous répondrons au
      plus vite.</p>
    <form class="form-container">
      <div class="form-inline">
        <div class="form-inputLabel form-inputLabel_inline">
          <InputField placeholder="Nom" id="nom" title="nom"/>
        </div>
        <div class="form-inputLabel form-inputLabel_inline">
          <InputField placeholder="Prénom" id="prenom" title="prénom"/>
        </div>
      </div>
      <div class="form-inline">
        <div class="form-inputLabel form-inputLabel_inline">
          <InputField placeholder="Email" id="email" title="email"/>
        </div>
        <div class="form-inputLabel form-inputLabel_inline">
          <InputField placeholder="Confirmez votre email" id="emailconfirmed" title="Confirmez votre email"/>
        </div>
      </div>
      <Textarea rows="5" cols="30" class="formContact-message" size="large" placeholder="Votre message"/>
      <CustomButton label="Envoyer"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>
.formContact-title {
  margin-bottom: 4rem;
}

.formContact-text {
  margin-bottom: 2rem;
  max-width: 440px;
  text-align: center;
}

.formContact-message:enabled:focus {
  border-color: var(--accent);
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>