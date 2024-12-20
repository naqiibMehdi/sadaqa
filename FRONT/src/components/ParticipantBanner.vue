<script setup lang="ts">

</script>

<template>
  <div class="participant-banner-infos">
    <div class="participant-banner-amount">
      100 €
    </div>
    <div class="participant-banner-participant">
      <span>Mehdi BENAMAR</span><span> a participé il y a 2 jours</span>
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

.participant-banner-participant span:first-child {
  font-weight: 600;
}

.participant-banner-participant span:last-child {
  font-size: 0.875rem;
}
</style>