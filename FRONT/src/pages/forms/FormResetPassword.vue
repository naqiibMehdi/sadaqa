<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import {usePasswordStore} from "@/stores/usePasswordStore.ts";
import {ref} from "vue";
import Message from "primevue/message";
import {useRoute, useRouter} from "vue-router";
import {useToast} from "primevue/usetoast";
import Password from "primevue/password";

const passwordStore = usePasswordStore()
const dataBodyPassword = ref({
  password: "",
  password_confirmation: ""
})
const route = useRoute()
const router = useRouter()
const toast = useToast()

const token = route.query.token as string
const email = route.query.email as string
const sendResetPassword = async () => {
  await passwordStore.resetPassword(dataBodyPassword.value, token, email)
  if (!passwordStore.errorsReset) {
    dataBodyPassword.value = {password: "", password_confirmation: ""}
    toast.add({severity: 'success', summary: 'Email', detail: passwordStore.message})
    await router.push({name: "login"})
  }
}
</script>

<template>
  <Header/>
  <Main>
    <h1 class="formResetPassword-title">Réinitialiser votre mot de passe</h1>
    <form class="form-container" @submit.prevent="sendResetPassword">
      <div class="form-inputLabel form-inputLabel_inline">
        <label for="password">Mot de passe</label>
        <Password
            placeholder="Mot de passe"
            input-id="password"
            :input-style="{width: '100%'}"
            :feedback="false"
            toggleMask
            v-model="dataBodyPassword.password"
            :invalid="passwordStore.errorsReset !== null"
        />
      </div>

      <div class="form-inputLabel form-inputLabel_inline">
        <label for="confirmation_password">Confirmez votre de passe</label>
        <Password
            placeholder="Mot de passe"
            input-id="confirmation_password"
            :input-style="{width: '100%'}"
            :feedback="false"
            toggleMask
            v-model="dataBodyPassword.password_confirmation"
            :invalid="passwordStore.errorsReset !== null"
        />
      </div>

      <RouterLink :to="{name: 'password.forget'}" class="formResetPassword-text">Envoyer un nouveau lien</RouterLink>
      <Message severity="error" variant="simple" size="small" v-if="passwordStore.errorsReset">
        {{ passwordStore.errorsReset }}
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

.formResetPassword-title {
  text-align: center;
}

.formConnexion-buttons-list button {
  width: 100%;
  font-size: 1.125rem;
  margin-top: 10px;
}

.formResetPassword-text {
  font-size: 0.9rem;
  color: var(--accent);
}

.formResetPassword-text:hover {
  text-decoration: underline;

}
</style>