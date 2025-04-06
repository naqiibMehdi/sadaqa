<script setup lang="ts">

import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {useIbanStore} from "@/stores/useIbanStore.ts";
import {computed, ref} from "vue";
import Message from "primevue/message";

const ibanStore = useIbanStore()

const iban = ref(ibanStore.iban)
const disable = ref(true)

const labelButton = computed(() => disable.value ? "Modifier  mon IBAN" : "Enregistrer mon IBAN")
const registerIban = () => {
  ibanStore.registerIban({iban: iban.value!})
}

const editIban = () => {
  disable.value = false
}

const cancelFormData = () => {
  disable.value = true
}
</script>

<template>
  <section class="iban">
    <form class="form-container iban-form" @submit.prevent="registerIban">
      <Message
          severity="error"
          variant="simple"
          size="small"
          v-if="ibanStore.errorsIban"
          v-for="(error) in ibanStore.errorsIban"
          :key="error"
      >
        {{ error }}
      </Message>
      <InputField placeholder="FR0000000000000" id="iban" title="IBAN:" v-model="iban!"
                  :disabled="disable && ibanStore.iban !== null"/>
      <small>* Seul les IBAN de France sont acceptés</small>
      <CustomButton label="Ajouter un IBAN" type="submit" :loading="ibanStore.loading" v-if="!ibanStore.iban"/>
      <div class="list-buttons-edit">
        <CustomButton
            :label="labelButton"
            :loading="ibanStore.loading"
            v-if="ibanStore.iban"
            @click="editIban"
        />
        <CustomButton
            label="Annuler"
            :disabled="ibanStore.loading"
            :outline="true"
            v-if="!disable"
            @click="cancelFormData"
        />
        <CustomButton
            label="Supprimer"
            :disabled="ibanStore.loading"
            v-if="disable"
        />
      </div>
    </form>
  </section>
</template>

<style scoped>

.iban {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.iban-form {
  width: 100%;
}

small {
  color: saddlebrown
}

.buttonFilled, .buttonOutlined {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

.buttonFilled:last-child {
  color: white;
  background-color: red;
}

.buttonFilled:hover:last-child {
  color: white;
  background-color: darkred;
}

</style>