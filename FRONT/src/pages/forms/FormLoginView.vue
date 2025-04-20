<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import {useToast} from "primevue/usetoast"

import {ref} from "vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useRouter} from "vue-router";
import Message from "primevue/message";

const router = useRouter()
const toast = useToast();
const authStore = useAuthStore()

const userData = ref({email: "", password: ""})

const submitLogin = async () => {
  await authStore.loginUser(userData.value)
  if (authStore.error) {
    toast.add({severity: 'error', summary: "Message d'erreur", detail: authStore.error, life: 5000});
  }

  if (authStore.token) {
    await router.push({name: 'dashboard'});
  }
}
</script>

<template>
  <Header/>
  <Main>
    <h1>Connectez-vous</h1>
    <form class="form-container" @submit.prevent="submitLogin">
      <InputField placeholder="Email" v-model="userData.email"
                  :invalid="authStore.errors?.email && authStore.errors.email?.[0] !== '' "/>
      <Message severity="error" variant="simple" size="small" v-if="authStore.errors.email?.[0]">{{
          authStore.errors.email?.[0]
        }}
      </Message>
      <InputField type="password" placeholder="Mot de passe" v-model="userData.password"
                  :invalid="authStore.errors?.password && authStore.errors.password?.[0] !== '' "/>
      <Message severity="error" variant="simple" size="small" v-if="authStore.errors.password?.[0]">{{
          authStore.errors.password?.[0]
        }}
      </Message>
      <RouterLink :to="{name: 'password.forget'}" class="formConnexion-text">Mot de passe oublié ?</RouterLink>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Connexion" type="submit" :loading="authStore.loading"/>
        <CustomButton label="S'inscrire" :outline="true" :disabled="authStore.loading"/>
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

.formConnexion-text {
  font-size: 0.9rem;
  text-align: right;
}

.formConnexion-text:hover {
  text-decoration: underline;
  color: var(--accent);
}

.formConnexion-buttons-list button {
  width: 100%;
  font-size: 1.125rem;
}
</style>