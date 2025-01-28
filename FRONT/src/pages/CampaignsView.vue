<script setup lang="ts">
import Header from "@/components/layouts/Header.vue"
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import CampaignsBanner from "@/components/CampaignsBanner.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import Pagination from "@/components/Pagination.vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import {onMounted, ref} from "vue";

const campaignStore = useCampaignStore();

onMounted(async () => {
  return await campaignStore.getCampaigns()
})

const first = ref({})

const te = (o) => {
  first.value = o
}


</script>

<template>
  <Header/>
  <Main>
    <CampaignsBanner/>
    <section class="container campaigns-cards">
      <CardCampaign v-for="campaign in campaignStore.campaigns.data" :key="campaign.id" :campaign="campaign"/>
    </section>
    <p>{{ first }}</p>
    <Pagination @test="te"/>
  </Main>
  <Footer/>
</template>
<style scoped>

.campaigns-cards {
  display: grid;
  grid-template-columns: repeat(3, minmax(250px, 1fr));
  grid-gap: 1rem;
}

@media (max-width: 900px) {
  .campaigns-cards {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
}
</style>