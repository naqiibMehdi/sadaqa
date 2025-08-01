<script setup lang="ts">

import type {Participant} from "@/types/types.ts";

defineProps<{ participants: Participant[] | [] | undefined, title?: string }>()

</script>

<template>
  <div class="participant-banner-infos" v-for="participant in participants" :key="participant.id">
    <div class="participant-banner-amount">
      {{ participant.amount / 100 }} €
    </div>
    <div class="participant-banner-participant">
      <span class="participant-name">{{ participant.name }}</span>
      <span class="participant-date"> a participé le {{
          (new Date(participant.participation_date)?.toLocaleDateString("fr-FR"))
        }}</span>
    </div>
  </div>
</template>

<style>
.participant-banner-infos {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  width: 100%;
}

.participant-banner-amount {
  width: max-content;
  background-color: var(--accent);
  padding: 6px 10px;
  border-radius: 5px;
  font-weight: 400;
}

.participant-banner-participant {
  width: 90%;
  display: flex;
  justify-content: space-between;
  background-color: var(--secondary20);
  padding: 6px 10px;
  border-radius: 5px;
}

.participant-name {
  font-weight: 600;
}

.participant-name {
  text-transform: capitalize;
}

.participant-date {
  font-size: 0.875rem;
}
</style>