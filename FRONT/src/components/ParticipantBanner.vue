<script setup lang="ts">

import {useRoute} from "vue-router";
import {computed} from "vue";
import type {Participant} from "@/types/types.ts";

defineProps<{ participants: Participant[] | [] | undefined, title?: string }>()

const route = useRoute()

const participantBannerDashboard = computed(() => {
  return route.name === "dashboard" ? "participant-banner-participant-dashboard" : "participant-banner-participant"
})
</script>

<template>
  <div class="participant-banner-infos" v-for="participant in participants" :key="participant.id">
    <div class="participant-banner-amount" v-if="route.name !== 'dashboard'">
      {{ participant.amount / 100 }} €
    </div>
    <div :class="participantBannerDashboard">
      <span v-if="route.name === 'dashboard'" class="participant-title">{{ participant.title || title }}</span>
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

.participant-banner-participant-dashboard {
  width: 100%;
  display: flex;
  justify-content: space-around;
  background-color: var(--secondary20);
  padding: 8px 10px;
  border-radius: 5px;
  margin-bottom: 1rem;
}

.participant-title, .participant-name {
  font-weight: 600;
}

.participant-name {
  text-transform: capitalize;
}

.participant-date {
  font-size: 0.875rem;
}
</style>