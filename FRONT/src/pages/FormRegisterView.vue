<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
import Select from "primevue/select"
import {ref, onMounted} from "vue";

const day = ref<string>("")
const days = ref<object[]>([])

const genereteDay = () => {
  let days = []
  for (let i = 1; i <= 31; i++) {
    days.push({value: i, option: i.toString(10).padStart(2, "0")})
  }

  return days
}

onMounted(() => days.value = genereteDay())
</script>

<template>
  <Header/>
  <Main>
    <h1>Formulaire d'inscription</h1>
    <form class="form-container">
      <div class="form-inline">
        <InputField placeholder="Nom" id="nom" title="nom"/>
        <InputField placeholder="Prénom" id="prenom" title="prénom"/>
      </div>
      <InputField placeholder="Ex: Toto" id="publicname" title="nom Public"/>
      <InputField placeholder="Email" id="email" title="email"/>
      <InputField placeholder="Mot de passe" id="password" title="mot de passe"/>
      <div class="formRegister-date">
        <p class="formRegister-title">Vous devez être majeur</p>
        <div class="formRegister-select">
          <Select v-model="day" placeholder="Jour" :options="days" optionLabel="option" optionValue="value"/>
          <Select v-model="day" placeholder="Jour" :options="days" optionLabel="option" optionValue="value"/>
          <Select v-model="day" placeholder="Jour" :options="days" optionLabel="option" optionValue="value"/>
        </div>
      </div>
      <CustomButton label="Créer votre compte"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formRegister-title {
  margin-bottom: 0.9rem;
}

.formRegister-select {
  width: 100%;
  display: inline-flex;
  gap: 1.3rem;
}

.p-select {
  width: calc(100% / 3);
}


.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>