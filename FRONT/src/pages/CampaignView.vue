<script setup lang="ts">
import Header from "@/components/layouts/Header.vue"
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import ParticipantBanner from "@/components/ParticipantBanner.vue";

import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import {onMounted} from "vue";
import {useRoute} from "vue-router";

const route = useRoute()
const slug = route.params.slug as string
const id = route.params.id as string

const campaignStore = useCampaignStore();

onMounted(async () => {
  return await campaignStore.getOneCampaign(slug, id);
})
</script>

<template>
  <Header/>
  <Main>
    <section class="campaign container" v-if="!campaignStore.loading && campaignStore.campaign">
      <h1 class="campaign-title">{{ campaignStore.campaign.title }}</h1>
      <div class="campaign-body">
        <section class="campaign-card-profil">
          <CardCampaign :campaign="campaignStore.campaign"/>
        </section>
        <section class="campaign-card-description">
          <p>{{ campaignStore.campaign.description }}</p>
        </section>
      </div>
      <div class="campaign-footer">
        <h2>Liste des participants</h2>
        <p v-if="campaignStore.campaign.participants && campaignStore.campaign.participants.length <= 0">Il n'y a aucun
          participants pour cette cagnotte</p>
        <ParticipantBanner v-for="participant in campaignStore.campaign.participants" :key="participant.id"
                           :participant="participant" :title="campaignStore.campaign.title" v-else/>
      </div>
    </section>
  </Main>
  <Footer/>
</template>

<style scoped>
.campaign {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2.5rem;
}

.campaign-title {
  font-size: 2.5rem;
  line-height: 3.625rem;
  text-align: center;
  font-weight: 900;
  margin-bottom: 0;
}

.campaign-title:first-letter {
  text-transform: uppercase;
}

.campaign-body {
  display: grid;
  grid-template-columns: minmax(340px, 1fr) 2fr;
  column-gap: 3rem;
}

.campaign-footer {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  width: 70%;
}


</style>