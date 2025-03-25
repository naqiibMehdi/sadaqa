<script setup lang="ts">

import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {useUserStore} from "@/stores/useUserStore.ts";
import {onMounted} from "vue";
import {storeToRefs} from "pinia";

const userStore = useUserStore()
const {user} = storeToRefs(userStore)

onMounted(() => {
  userStore.getInfosUser()
})
</script>

<template>
  <section class="profil">
    <FileUploaderProfil :image-profile="user.image_profile"/>
    <form class="form-container profil-form">
      <div class="form-inline">
        <InputField placeholder="Nom" id="nom" title="nom" v-model="user.name"/>
        <InputField placeholder="Prénom" id="prenom" title="prénom" v-model="user.first_name"/>
      </div>
      <InputField placeholder="example@gmail.com" id="email" title="Adresse email" v-model="user.email"/>
      <p>Date de naissance:
        <strong>{{ (new Date(user.birth_date).toLocaleDateString()) }}</strong>
      </p>
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

.profil-form {
  width: 100%;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>