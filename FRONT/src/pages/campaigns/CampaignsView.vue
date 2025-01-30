<script setup lang="ts">
import Header from "@/components/layouts/Header.vue"
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import CampaignsBanner from "@/components/CampaignsBanner.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import {onMounted, watch} from "vue";
import Paginator, {PageState} from "primevue/paginator";
import {useRoute, useRouter} from "vue-router";

const campaignStore = useCampaignStore();
const router = useRouter()
const route = useRoute()
const fetchCampaigns = async () => await campaignStore.getCampaigns()

onMounted(() => {
  fetchCampaigns()
})


const onPageChange = (e: PageState) => {
  campaignStore.setPage(e.page + 1)
  router.push({query: {page: campaignStore.currentPage}})
}

watch(() => route.query.page, () => {
  if (route.fullPath === "/campaigns") {
    fetchCampaigns()
  }
})

</script>

<template>
  <Header/>
  <Main>
    <CampaignsBanner/>
    <section class="container campaigns-cards">
      <CardCampaign v-for="campaign in campaignStore.campaigns.data" :key="campaign.id" :campaign="campaign"/>
    </section>
    <section class="pagination">
      <Paginator :rows="campaignStore.itemsPerPage"
                 :totalRecords="campaignStore.totalItems" @page="onPageChange"/>
    </section>
  </Main>
  <Footer/>
</template>
<style scoped>

.campaigns-cards {
  display: grid;
  grid-template-columns: repeat(3, minmax(250px, 1fr));
  grid-gap: 1rem;
}

.pagination {
  margin-top: 2rem;
}

@media (max-width: 900px) {
  .campaigns-cards {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
}
</style>