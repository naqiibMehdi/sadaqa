<script setup lang="ts">

import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {onMounted, ref, watch} from "vue";
import {Address} from "@/types/types.ts";
import {useAddressStore} from "@/stores/useAddressStore.ts";
import Message from "primevue/message";
import {useToast} from "primevue/usetoast";

const addressStore = useAddressStore()
const toast = useToast()

const disabled = ref(true)
const dataAddress = ref<Address | null>(addressStore.address || {
  address: "",
  city: "",
  country: "",
  postal_code: "",
})

onMounted(() => {
  addressStore.getAddress()
})

watch(() => addressStore.address, (newAddress) => {
  dataAddress.value = newAddress
})

const registerAddress = async () => {
  await addressStore.registerAddress(dataAddress.value!)
  if (addressStore.errorsAddress === null) {
    toast.add({severity: 'success', summary: "Message de succès", detail: addressStore.message, life: 5000});
  }
}

const editAddress = async () => {
  if (!disabled.value) {
    await addressStore.editAddress(dataAddress.value!)
    if (addressStore.errorsAddress === null) {
      disabled.value = true
      toast.add({severity: 'success', summary: "Message de succès", detail: addressStore.message, life: 5000});
    }
    return
  }

  disabled.value = !disabled.value
}

const cancelFormDataAddress = () => {
  dataAddress.value = addressStore.address
  addressStore.errorsAddress = null
  disabled.value = true
}

</script>

<template>
  <section class="address">
    <form class="form-container address-form">
      <InputField placeholder="adresse" id="address" title="Adresse" v-model="(dataAddress as Address).address"
                  :disabled="disabled && addressStore.address !== null"/>
      <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.address?.[0]">
        {{ addressStore.errorsAddress?.address?.[0] }}
      </Message>
      <InputField placeholder="ex: 27000" id="postal_code" title="Code postale"
                  v-model="(dataAddress as Address).postal_code"
                  :disabled="disabled && addressStore.address !== null"/>
      <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.postal_code?.[0]">
        {{ addressStore.errorsAddress?.postal_code?.[0] }}
      </Message>
      <div class="form-inline">
        <div class="input-error">
          <InputField placeholder="Paris" id="city" title="Ville" v-model="(dataAddress as Address).city"
                      :disabled="disabled && addressStore.address !== null"/>
          <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.city?.[0]">
            {{ addressStore.errorsAddress?.city?.[0] }}
          </Message>
        </div>
        <div class="input-error">
          <InputField placeholder="France" id="country" title="Pays" v-model="(dataAddress as Address).country"
                      :disabled="disabled && addressStore.address !== null"/>
          <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.country?.[0]">
            {{ addressStore.errorsAddress?.country?.[0] }}
          </Message>
        </div>
      </div>
      <CustomButton
          label="Ajouter mon adresse"
          @click="registerAddress"
          :loading="addressStore.loading"
          v-if="!addressStore.address"
      />
      <div class="list-button">
        <CustomButton
            :label="disabled ? 'Modifier mon adresse' : 'Enregistrer'"
            :loading="addressStore.loading"
            @click="editAddress"
            v-if="addressStore.address"
        />
        <CustomButton
            label="Annuler"
            :outline="true"
            :disabled="addressStore.loading"
            v-if="!disabled"
            @click="cancelFormDataAddress"
        />
      </div>
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

.input-error {
  width: 50%;
}

.address-form .buttonFilled, .address-form .buttonOutlined {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>