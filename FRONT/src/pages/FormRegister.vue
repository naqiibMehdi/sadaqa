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
    <form class="formConnexion-container">
      <div class="formRegister-inline">
        <div class="formRegister-inputLabel formRegister-inputLabel_inline">
          <InputField placeholder="Nom" id="nom" title="nom"/>
        </div>
        <div class="formRegister-inputLabel formRegister-inputLabel_inline">
          <InputField placeholder="Prénom" id="prenom" title="prénom"/>
        </div>
      </div>
      <div class="formRegister-inputLabel">
        <InputField placeholder="Ex: Toto" id="publicname" title="nom Public"/>
      </div>
      <div class="formRegister-inputLabel">
        <InputField placeholder="Email" id="email" title="email"/>
      </div>
      <div class="formRegister-inputLabel">
        <InputField placeholder="Mot de passe" id="password" title="mot de passe"/>
      </div>
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

.formConnexion-container {
  display: flex;
  flex-direction: column;
  row-gap: 1.3rem;
  width: calc(100% / 2);
  max-width: 700px;
}

.formRegister-inline {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
  width: 100%;
}

.formRegister-inputLabel_inline {
  width: 50%;
}

.formRegister-inputLabel {
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
}

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
}
</style>