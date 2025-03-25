<script setup lang="ts">

import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";

</script>

<template>
  <section class="address">
    <form class="form-container address-form">
      <InputField placeholder="FR0000000000000" id="iban" title="IBAN:"/>
      <CustomButton label="Enregistrer mon IBAN"/>
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