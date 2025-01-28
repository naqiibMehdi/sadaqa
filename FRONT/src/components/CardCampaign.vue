<script setup lang="ts">
import Card from "primevue/card"
import CustomButton from "@/components/CustomButton.vue";
import {useRoute} from "vue-router";
import type {Campaign} from "@/types/types.ts";

defineProps<{ campaign: Campaign }>()

const route = useRoute()
</script>


<template>
  <Card class="card-campaign">
    <template #header>
      <img :src="campaign.url_image" alt="">
      <div class="card-campaign-profil">
        <img :src="campaign.user.image_profile"
             alt="photo de profil" class="card-campaign-profil-img">
        <div class="card-campaign-profil-infos">
          <p><span>{{ campaign.user.public_name }}</span><br/> Lancée le {{
              (new Date(campaign.created_at).toLocaleDateString("fr-FR"))
            }}</p>
        </div>
      </div>
    </template>
    <template #title><h2 class="card-campaign-title">{{ campaign.title }}</h2></template>
    <template #content>
      <div class="card-campaign-content">
        <p class="card-campaign-content-price">{{ campaign.collected_amount / 100 }} €</p>
        <p class="card-campaign-content-participant">récoltés avec <span>{{ campaign.participants.length }}</span>
          participants</p>
        <CustomButton label="Participez" class="card-campaign-content-btn" v-if="route.name !== 'campaigns'"/>
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

.card-campaign-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
}

.card-campaign-content-btn {
  width: 100%;
  font-size: 1.125rem;
  margin-top: 1rem;
}

.card-campaign-content-price {
  font-size: 1.75rem;
}

.card-campaign-content-participant span {
  font-weight: 600;
}
</style>