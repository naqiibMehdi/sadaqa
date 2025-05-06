<script setup lang="ts">
import Header from "@/components/layouts/Header.vue"
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import ParticipantBanner from "@/components/ParticipantBanner.vue";
import Divider from 'primevue/divider';

import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import {onMounted} from "vue";
import {useRoute} from "vue-router";
import {useToast} from "primevue/usetoast";

const toast = useToast()
const route = useRoute()
const slug = route.params.slug as string
const id = route.params.id as string

const campaignStore = useCampaignStore();


onMounted(async () => {
  if (route.query.cancel && route.query.cancel === "1") {
    toast.add({severity: 'error', summary: "Echec", detail: "Votre payement a été annulé", life: 5000});
  }
  if (route.query.success && route.query.success === "1") {
    toast.add({severity: 'success', summary: "Succès", detail: "Payement réalisé avec succès", life: 5000});
  }
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
          <h2 class="campaign-card-description-title">Description</h2>
          <div v-html="campaignStore.campaign.description"></div>
        </section>
      </div>
      <Divider/>
      <div class="campaign-footer">
        <h2>Liste des participants</h2>
        <p v-if="campaignStore.campaign.participants && campaignStore.campaign.participants.length <= 0">Il n'y a aucun
          participants pour cette cagnotte</p>
        <ParticipantBanner
            :participants="campaignStore?.campaign?.participants"
            :title="campaignStore.campaign.title"
            v-else
        />
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

.campaign-card-description {
  place-self: center;
}

.campaign-card-description-title {
  text-align: center;
  margin-bottom: 2rem;
}

::v-global(.campaign-card-description a) {
  color: var(--primary);
  text-decoration: underline;
}

::v-global(.campaign-card-description img) {
  width: 450px;
  object-fit: contain;
}

.campaign-footer {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  width: 70%;
}

</style>