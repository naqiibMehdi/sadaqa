<script setup lang="ts">
import {ref} from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

defineProps<{
  campaign: {
    id: number | string;
    title: string;
    collected_amount: number;
  }
}>();


const emit = defineEmits(['submitted']);
const loading = ref(false);
const iban = ref('');
const visible = ref(false);


const show = () => {
  visible.value = true;
}

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(amount);
};

const submitTransferRequest = async () => {
  loading.value = true;

  // Ici, vous implémenteriez l'appel API pour soumettre la demande de virement
  // Par exemple:
  // const result = await campaignStore.requestTransfer({
  //   campaignId: props.campaign.id,
  //   method: transferMethod.value.id,
  //   iban: iban.value,
  //   paypalEmail: paypalEmail.value,
  //   note: transferNote.value
  // });

  // Simulation pour l'exemple
  await new Promise(resolve => setTimeout(resolve, 1500));

  loading.value = false;
  visible.value = false;

  emit('submitted', {
    success: true,
    message: "Votre demande de virement a été soumise avec succès"
  });
};

defineExpose({
  show
})

</script>

<template>
  <div class="transfer-request-dialog">
    <Dialog v-model:visible="visible" modal header="Demande de virement" :style="{ width: '28rem', maxWidth: '800px' }">
      <div class="transfer-info">
        <h3>Informations de virement pour la cagnotte: "{{ campaign.title }}"</h3>
        <p class="amount">Montant disponible : <strong>{{ formatCurrency(campaign.collected_amount / 100) }}</strong>
        </p>

        <div class="transfer-form">

          <div class="form-group">
            <label for="iban">IBAN</label>
            <InputText id="iban" v-model="iban" placeholder="FR76 XXXX XXXX XXXX XXXX XXXX XXX"/>
            <small>Vérifiez que votre IBAN est correct</small>
          </div>


          <div class="transfer-notice">
            <i class="pi pi-info-circle"></i>
            <div>
              <p>Le virement sera traité dans un délai de 3 à 5 jours ouvrés.</p>
              <p>Des frais de traitement de 2,5% peuvent s'appliquer selon votre mode de paiement.</p>
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button label="Annuler" icon="pi pi-times" @click="visible = false" class="p-button-text"/>
        <Button
            label="Confirmer la demande"
            icon="pi pi-check"
            @click="submitTransferRequest"
            :loading="loading"
            class="p-button-success"
        />
      </template>
    </Dialog>
  </div>
</template>

<style scoped>
.transfer-request-dialog {
  display: flex;
  justify-content: center;
  background-color: #3c4c67;
}

.transfer-info {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.amount {
  font-size: 1.2rem;
  margin-bottom: 1rem;
}

.transfer-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.transfer-notice {
  display: flex;
  gap: 0.75rem;
  background-color: lightblue;
  padding: 1rem;
  border-radius: 6px;
  margin-top: 1rem;
}

.transfer-notice i {
  font-size: 1.5rem;
  color: lightblue;
}
</style>