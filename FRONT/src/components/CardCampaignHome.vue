<script setup lang="ts">
import Card from "primevue/card"
import type {Campaign} from "@/types/types.ts";

// defineProps<{ campaign: Campaign }>()

</script>


<template>
  <Card class="card-campaign">
    <template #header>
      <img src="https://picsum.photos/200/300" alt="image de la cagnotte">
    </template>
    <template #title><h2 class="card-campaign-title">Titre cagnotte</h2></template>
    <template #content>
      <div class="card-campaign-content">
        <p class="card-campaign-content-price">100 000 €</p>
        <p class="card-campaign-content-participant">récoltés avec <span>200 000 €</span></p>
      </div>
    </template>
  </Card>
</template>

<style scoped>
.card-campaign {
  overflow: hidden;
  border-radius: unset;
}

.card-campaign:hover {
  cursor: pointer;
}


.card-campaign-profil-infos p,
.card-campaign-profil-infos span {
  color: #ffffff;
  text-shadow: 0 1px 1px var(--text), 0 1px 4px var(--text);
}

.card-campaign-profil-infos span {
  font-size: 1rem;
}

.card-campaign-title {
  font-size: 1.125rem;
  text-align: center;
  text-transform: capitalize;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  font-weight: 900;
}

.card-campaign-title:first-letter {
  text-transform: uppercase;
}

.card-campaign-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
}


.card-campaign-content-price {
  font-size: 1.75rem;
}

.card-campaign-content-participant span {
  font-weight: 600;
}
</style>