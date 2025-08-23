<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import InputNumber from "primevue/inputnumber";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import {onMounted, ref} from "vue";
import {usePaymentStore} from "@/stores/usePaymentStore.ts";
import {useRoute, useRouter} from "vue-router";
import Message from "primevue/message";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import MdiInformationVariantCircle from '~icons/mdi/information-variant-circle';

const route = useRoute()
const router = useRouter()
const paymentStore = usePaymentStore()
const campaignStore = useCampaignStore()
const formPayment = ref({name: "", email: "", amount: 0})

onMounted(() => {
  if (!campaignStore.campaign || campaignStore.campaign.closing_date !== null) {
    router.push({name: "campaigns"})
  }
})
const sendPayment = async () => {
  await paymentStore.checkoutSessionPayment(route.params.slug as string, route.params.id as string, formPayment.value)
}

</script>

<template>
  <Header/>
  <Main>
    <h1>Formulaire de payement</h1>
    <form class="form-container" @submit.prevent="sendPayment">
      <div class="form-inputLabel form-inputLabel_inline">
        <label for="currency-fr" class="font-bold block mb-2">Montant de votre donation</label>
        <InputNumber v-model="formPayment.amount" inputId="currency-fr" mode="currency" currency="EUR" locale="fr-FR"
                     :minFractionDigits="0" :maxFractionDigits="0" size="large"
                     :invalid="paymentStore.errors?.amount !== ''"/>
        <Message severity="error" variant="simple" size="small" v-if="paymentStore.errors?.amount">
          {{ paymentStore.errors?.amount }}
        </Message>
      </div>
      <InputField placeholder="Votre nom et prénom" title="Vos coordonnées" id="name" v-model="formPayment.name"
                  :invalid="paymentStore.errors?.name !== ''"/>
      <Message severity="error" variant="simple" size="small" v-if="paymentStore.errors?.name">
        {{ paymentStore.errors?.name }}
      </Message>
      <InputField placeholder="Email" id="email" v-model="formPayment.email"
                  :invalid="paymentStore.errors?.email !== ''"/>
      <Message severity="error" variant="simple" size="small" v-if="paymentStore.errors?.email">
        {{ paymentStore.errors?.email }}
      </Message>

      <CustomButton label="Payer" type="submit" :loading="paymentStore.loading"/>
      <Message severity="info" style="line-height: 1.25rem">
        <template #icon>
          <MdiInformationVariantCircle width="2rem" height="2rem"/>
        </template>
        Une commission solidaire de 2,5 % sera prélevée sur le montant total récolté par le créateur de la cagnotte pour
        couvrir les frais techniques et de
        fonctionnement de l’association.<br> Pour une récolte totale de 100 €, 2,50 € seront reversés à l'association.
      </Message>
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