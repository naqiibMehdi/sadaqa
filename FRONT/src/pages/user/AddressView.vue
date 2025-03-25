<script setup lang="ts">

import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";

</script>

<template>
  <section class="address">
    <form class="form-container address-form">
      <InputField placeholder="adresse" id="address" title="Adresse"/>
      <InputField placeholder="ex: 27000" id="postal_code" title="Code postale"/>
      <div class="form-inline">
        <InputField placeholder="Paris" id="borntown" title="Ville"/>
        <InputField placeholder="France" id="borncountry" title="Pays"/>
      </div>
      <CustomButton label="Enregistrer mon adresse"/>
    </form>
  </section>
</template>

<style scoped>

.address {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.address-form {
  width: 100%;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>