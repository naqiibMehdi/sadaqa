<script setup lang="ts">
import {ref} from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import {useRecoveryStore} from "@/stores/useRecoveryStore.ts";
import {useToast} from "primevue/usetoast";
import {useIbanStore} from "@/stores/useIbanStore.ts";

const props = defineProps<{
  campaign: {
    id: number | string;
    title: string;
    collected_amount: number;
  } | null
}>();


const recoveryStore = useRecoveryStore()
const ibanStore = useIbanStore()

const emit = defineEmits(['submitted']);

const iban = ref(ibanStore.iban || '');
const visible = ref(false);
const toast = useToast()


const show = async () => {
  if (!ibanStore.iban) {
    await ibanStore.getIban()
  }
  iban.value = ibanStore.iban || '';
  visible.value = true;
}

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(amount);
};

const submitTransferRequest = async () => {
  await recoveryStore.registerRecovery(props.campaign?.id as number, {iban: iban.value})

  if (recoveryStore.errors) {
    toast.add({severity: 'error', summary: "Erreur", detail: recoveryStore.errors.join("\n")});
    return
  } else if (recoveryStore.errorMessage) {
    toast.add({severity: 'error', summary: "Erreur", detail: recoveryStore.errorMessage});
    return
  } else {
    if (!iban.value || !ibanStore.iban) {
      await ibanStore.registerIban({iban: iban.value})
    }
    toast.add({
      severity: 'success',
      summary: "Succès",
      detail: "Votre demande de virement a été enregistrée avec succès !"
    });

  }

  visible.value = false;
  iban.value = '';

  emit('submitted', {
    success: true,
    message: "Votre demande de virement a été soumise avec succès"
  });
};

const cancelTransferRequest = () => {
  visible.value = false;
  recoveryStore.errors = null
}

defineExpose({
  show
})

</script>

<template>
  <div class="transfer-request-dialog">
    <Dialog v-model:visible="visible" modal header="Demande de virement" :style="{ width: '28rem', maxWidth: '800px' }">
      <div class="transfer-info">
        <h3>Informations de virement pour la cagnotte: "{{ campaign?.title }}"</h3>
        <p class="amount">Montant disponible : <strong>{{
            formatCurrency((campaign?.collected_amount as number) / 100)
          }}</strong>
        </p>

        <div class="transfer-form">

          <div class="form-group">
            <label for="iban">IBAN</label>
            <InputText
                id="iban"
                v-model="iban"
                placeholder="FR76XXXXXXXXXXXXXXXXXXXXXXX"
                :invalid="recoveryStore.errors && recoveryStore.errors.length > 0"
                :disabled="ibanStore.iban !== null"
            />
            <small>Vérifiez que votre IBAN est correct. Seul les IBAN français sont acceptés</small>
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
        <Button label="Annuler" @click="cancelTransferRequest" class="p-button-text"/>
        <Button
            label="Confirmer la demande"
            @click="submitTransferRequest"
            :loading="recoveryStore.loading"
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