<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import InputNumber from "primevue/inputnumber";
import InputMask from "primevue/inputmask";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
import {ref} from "vue";

const amount = ref<number>(0)

</script>

<template>
  <Header/>
  <Main>
    <h1>Formulaire de payement</h1>
    <form class="form-container">
      <div class="form-inputLabel form-inputLabel_inline">
        <label for="currency-fr" class="font-bold block mb-2">Montant de votre donation</label>
        <InputNumber v-model="amount" inputId="currency-fr" mode="currency" currency="EUR" locale="fr-FR"
                     fluid/>
      </div>
      <InputField placeholder="Votre nom et prénom" title="Vos coordonnées" id="names"/>
      <InputField placeholder="Email"/>
      <div class="form-inputLabel form-inputLabel_inline">
        <label for="numberCreditCard">Votre carte bancaire</label>
        <InputMask id="numberCreditCard" mask="9999999999999999999" placeholder="1234 1234 1234 1234" slotChar=""
                   fluid/>
      </div>
      <div class="form-inline">
        <div class="form-inputLabel form-inputLabel_inline">
          <InputMask mask="99/99" placeholder="MM/AA" slotChar="MM/AA"
                     fluid/>
        </div>
        <div class="form-inputLabel form-inputLabel_inline">
          <InputMask mask="999" placeholder="CVC" slotChar=""
                     fluid/>
        </div>
      </div>
      <CustomButton label="Payer"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>