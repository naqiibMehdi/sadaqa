<script setup lang="ts">
import {onMounted} from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import Skeleton from 'primevue/skeleton';
import {useRecoveryStore} from "@/stores/useRecoveryStore.ts";
import CustomButton from "@/components/CustomButton.vue";
import {usePdfStore} from "@/stores/usePdfStore.ts";

type StatusType = "pending" | "processed" | "failed"

const recoveryStore = useRecoveryStore()
const pdfStore = usePdfStore()

const listStatus: Record<StatusType, string> = {pending: "En cours", processed: "Effectué", failed: "Refusé"}

onMounted(async () => {
  await recoveryStore.getRecoveries()
})

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(amount);
};

const formatDate = (date: string) => {
  return (new Date(date).toLocaleDateString("fr-FR"))
}

const getStatusLabel = (status: string): string => {
  return listStatus[status as StatusType] || "Statut inconnu";
};

const getStatusSeverity = (recovery: {
  id: number,
  title: string,
  created_at: string,
  amount: number,
  status: string
}) => {
  switch (recovery.status) {
    case 'pending':
      return 'info';
      break;
    case 'processed':
      return 'success';
      break;
    case 'failed':
      return 'danger';
      break;
  }
}

</script>

<template>
  <section class="recoveries container">
    <table style="min-width: 20rem; width: 100%" v-if="recoveryStore.loading">
      <thead>
      <tr>
        <th>
          <Skeleton height="1.25rem"></Skeleton>
        </th>
        <th>
          <Skeleton height="1.25rem"></Skeleton>
        </th>
        <th>
          <Skeleton height="1.25rem"></Skeleton>
        </th>
        <th>
          <Skeleton height="1.25rem"></Skeleton>
        </th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td colspan="4" style="padding-top: 1rem;">
          <Skeleton height="1.25rem"></Skeleton>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="padding-top: .5rem;">
          <Skeleton height="1.25rem"></Skeleton>
        </td>
      </tr>
      </tbody>
    </table>

    <div v-else>
      <h2 v-if="recoveryStore.recoveries === null">Vous n'avez aucune demande de virements</h2>
      <DataTable :value="recoveryStore.recoveries" stripedRows tableStyle="min-width: 250px" v-else>
        <Column field="title" header="Titre" style="min-width: 25%"></Column>
        <Column header="Demandé le">
          <template #body="slotProps">
            {{ formatDate(slotProps.data.created_at) }}
          </template>
        </Column>
        <Column header="Montant">
          <template #body="slotProps">
            {{ formatCurrency(slotProps.data.total_amount / 100) }}
          </template>
        </Column>
        <Column header="Status">
          <template #body="slotProps">
            <Tag
                :value="getStatusLabel(slotProps.data.status)"
                :severity="getStatusSeverity(slotProps.data)"
            />
          </template>
        </Column>
        <Column header="Facture">
          <template #body="slotProps">
            <CustomButton
                style="width: 100%"
                label="Télécharger"
                size="small"
                :disabled="pdfStore.hasAnyLoading && !pdfStore.isLoading(slotProps.data.id)"
                :loading="pdfStore.isLoading(slotProps.data.id)"
                @click="() => pdfStore.downloadCampaignPdf(slotProps.data.id)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
  </section>
</template>

<style scoped>

.recoveries {
  padding-inline: 10px;
}

.recoveries h2 {
  text-align: center;
  font-size: 1.3rem
}

</style>