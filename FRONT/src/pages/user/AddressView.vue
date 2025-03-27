<script setup lang="ts">

import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {onMounted, ref} from "vue";
import {Address} from "@/types/types.ts";
import {useUserStore} from "@/stores/useUserStore.ts";
import {useAddressStore} from "@/stores/useAddressStore.ts";
import Message from "primevue/message";
import {useToast} from "primevue/usetoast";

const userStore = useUserStore()
const addressStore = useAddressStore()
const toast = useToast()

const dataAddress = ref<Address>(addressStore.address || {
  address: "",
  city: "",
  country: "",
  postal_code: "",
  user_id: userStore.user.id as number
})

onMounted(() => {
  addressStore.getAddress()
})

const sendDataAddress = async () => {
  await addressStore.registerAddress(dataAddress.value)

  if (addressStore.errorsAddress === null) {
    toast.add({severity: 'success', summary: "Message de succès", detail: addressStore.message, life: 5000});
  }
}

</script>

<template>
  <section class="address">
    <form class="form-container address-form">
      <InputField placeholder="adresse" id="address" title="Adresse" v-model="dataAddress.address"/>
      <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.address?.[0]">
        {{ addressStore.errorsAddress?.address?.[0] }}
      </Message>
      <InputField placeholder="ex: 27000" id="postal_code" title="Code postale" v-model="dataAddress.postal_code"/>
      <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.postal_code?.[0]">
        {{ addressStore.errorsAddress?.postal_code?.[0] }}
      </Message>
      <div class="form-inline">
        <div class="input-error">
          <InputField placeholder="Paris" id="city" title="Ville" v-model="dataAddress.city"/>
          <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.city?.[0]">
            {{ addressStore.errorsAddress?.city?.[0] }}
          </Message>
        </div>
        <div class="input-error">
          <InputField placeholder="France" id="country" title="Pays" v-model="dataAddress.country"/>
          <Message severity="error" variant="simple" size="small" v-if="addressStore.errorsAddress?.country?.[0]">
            {{ addressStore.errorsAddress?.country?.[0] }}
          </Message>
        </div>
      </div>
      <CustomButton
          :label="addressStore.address ? 'Modifier mon adresse' : 'Enregistrer mon adresse'"
          @click="sendDataAddress" :loading="addressStore.loading"
      />
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

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>