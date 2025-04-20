<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import {usePasswordStore} from "@/stores/usePasswordStore.ts";
import {ref} from "vue";
import Message from "primevue/message";
import {useToast} from "primevue/usetoast";

const toast = useToast()
const passwordStore = usePasswordStore()
const email = ref("")
const sendEmail = async () => {
  await passwordStore.sendEmailToResetPassword({email: email.value})
  if (!passwordStore.errorsForget) {
    email.value = ""
    toast.add({severity: 'success', summary: 'Email', detail: passwordStore.message})
  }
}
</script>

<template>
  <Header/>
  <Main>
    <h1 class="forget-pwd-title">Vous avez oublié votre mot de passe ?</h1>
    <p class="forget-pwd-text">Saisissez votre email afin de recevoir un email permettant de réinitialiser votre mot
      de passe.</p>
    <form action="" class="form-container" @submit.prevent="sendEmail">
      <InputField placeholder="Email" v-model="email"/>
      <Message severity="error" variant="simple" size="small" v-if="passwordStore.errorsForget">
        {{ passwordStore.errorsForget[0] }}
      </Message>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Valider" type="submit" :loading="passwordStore.loading"/>
      </div>
    </form>
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

.forget-pwd-text {
  margin-bottom: 1rem;
}

.formConnexion-buttons-list button {
  width: 100%;
  font-size: 1.125rem;
}
</style>