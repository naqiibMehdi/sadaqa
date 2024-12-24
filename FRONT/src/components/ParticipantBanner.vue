<script setup lang="ts">

import {useRoute} from "vue-router";
import {computed} from "vue";

const route = useRoute()

const participantBannerDashboard = computed(() => {
  return route.name === "dashboard" ? "participant-banner-participant-dashboard" : "participant-banner-participant"
})
</script>

<template>
  <div class="participant-banner-infos">
    <div class="participant-banner-amount" v-if="route.name !== 'dashboard'">
      100 €
    </div>
    <div :class="participantBannerDashboard">
      <span v-if="route.name === 'dashboard'">titre de la cagnotte</span><span>Mehdi BENAMAR</span><span> a participé il y a 2 jours</span>
    </div>
  </div>
</template>

<style>
.participant-banner-infos {
  display: flex;
  align-items: center;
  gap: 1rem;
  width: 100%;
}

.participant-banner-amount {
  background-color: var(--accent);
  padding: 6px 10px;
  border-radius: 5px;
  font-weight: 400;
}

.participant-banner-participant {
  flex-grow: 2;
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

.participant-banner-participant span:first-child,
.participant-banner-participant-dashboard span:first-child {
  font-weight: 600;
}

.participant-banner-participant span:last-child,
.participant-banner-participant-dashboard span:last-child {
  font-size: 0.875rem;
}
</style>