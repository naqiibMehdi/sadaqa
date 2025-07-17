<script setup lang="ts">
import {onMounted} from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {useRecoveryStore} from "@/stores/useRecoveryStore.ts";

type StatusType = "pending" | "processed" | "failed"

const recoveryStore = useRecoveryStore()

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

</script>

<template>
  <section class="recoveries">
    <DataTable :value="recoveryStore.recoveries" stripedRows tableStyle="min-width: 50rem">
      <Column field="title" header="Titre"></Column>
      <Column header="Demandé le">
        <template #body="slotProps">
          {{ formatDate(slotProps.data.created_at) }}
        </template>
      </Column>
      <Column header="Montant">
        <template #body="slotProps">
          {{ formatCurrency(slotProps.data.amount / 100) }}
        </template>
      </Column>
      <Column header="Status">
        <template #body="slotProps">
          {{ getStatusLabel(slotProps.data.status) }}
        </template>
      </Column>
    </DataTable>
  </section>
</template>

<style scoped>

</style>