<script setup lang="ts">
import Card from "primevue/card"

defineProps<{ baseUrl: string }>()
</script>


<template>
  <Card class="card-campaign">
    <template #header>
      <img :src="baseUrl" alt="">
      <div class="card-campaign-profil">
        <img src="https://cotizup-uploads.s3.eu-west-3.amazonaws.com/uploads/660d970a17ba7111408188.png"
             alt="photo de profil" class="card-campaign-profil-img">
        <div class="card-campaign-profil-infos">
          <p><span>Nom public de l'utilisateur</span><br/> Lancée le {{
              (new Date().toLocaleDateString())
            }}</p>
        </div>
      </div>
    </template>
    <template #title><h2 class="card-campaign-title">titre de la cagnotte</h2></template>
    <template #content>
      <div class="card-campaign-content">
        <p class="card-campaign-content-price">10000 €</p>
        <p class="card-campaign-content-participant">récoltés avec <span>40</span> participants</p>
      </div>
    </template>
  </Card>
</template>

<style scoped>
.card-campaign {
  overflow: hidden;
  border-radius: unset;
}

.card-campaign-profil {
  position: absolute;
  left: 10px;
  bottom: 10px;
  display: inline-flex;
  align-items: center;
  gap: 1rem;
}

.card-campaign-profil-img {
  width: 60px;
  height: 60px;
  border-radius: 50px;
  border: 3px solid var(--secondary);
}

.card-campaign-profil-infos {
  font-size: 0.8125rem;
  line-height: 19px;
}

.card-campaign-profil-infos p,
.card-campaign-profil-infos span {
  color: #ffffff;
  text-shadow: 0 1px 1px var(--primary), 0 1px 4px var(--primary);
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

.card-campaign-content p {
  text-align: center;
}

.card-campaign-content-price {
  font-size: 1.75rem;
}

.card-campaign-content-participant span {
  font-weight: 600;
}
</style>