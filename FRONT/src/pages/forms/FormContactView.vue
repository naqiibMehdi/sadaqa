<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import Textarea from "primevue/textarea";

</script>

<template>
  <Header/>
  <Main>
    <h1>Assisstance</h1>
    <p class="formContact-text">Si vous avez besoin d'aide, contactez-nous en utilisant le
      formulaire ci-dessous. Nous vous répondrons dans les plus brefs délais.</p>
    <form class="form-container">
      <div class="form-inline">
        <InputField placeholder="Email" id="email" title="Votre email :"/>
      </div>
      <label>Votre message :</label>
      <Textarea rows="5" cols="30" class="formContact-message" size="large" placeholder="Votre message"/>
      <CustomButton label="Envoyer votre message" type="submit"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formContact-text {
  margin-bottom: 2rem;
  max-width: 600px;
  text-align: center;
  line-height: 1.25rem;
  padding-inline: 10px;
}

.formContact-message:enabled:focus {
  border-color: var(--accent);
}

label {
  text-transform: capitalize;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>