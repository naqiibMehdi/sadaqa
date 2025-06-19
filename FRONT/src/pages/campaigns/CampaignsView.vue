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


onMounted(async () => {
  await campaignStore.getCampaigns(route.query.page as string || 1, route.query.search as string || "")
})


const onPageChange = (e: PageState) => {
  campaignStore.setPage(Number(e.page + 1))
  let query: { page: number, search?: string } = {page: campaignStore.currentPage}
  if (campaignStore.currentSearch) {
    query = {...query, search: campaignStore.currentSearch}
  }
  router.push({query})
}

watch(() => route.query, (newParams) => {

  campaignStore.setSearch(newParams.search as string || "")

  if (!newParams.page) {
    campaignStore.setPage(1)
    return
  }
  campaignStore.setPage(Number(newParams.page))

}, {deep: true})


</script>

<template>
  <Header/>
  <Main>
    <CampaignsBanner/>
    <section class="container campaigns-cards">
      <p v-if="campaignStore.error" class="campaigns-cards-error">{{ campaignStore.error }}</p>
      <CardCampaign v-for="campaign in campaignStore.campaigns.data" :key="campaign.id" :campaign="campaign" v-else/>
    </section>
    <section class="pagination">
      <Paginator :first="(Number(campaignStore.currentPage) - 1) * campaignStore.itemsPerPage"
                 :rows="campaignStore.itemsPerPage"
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
  margin-bottom: 2rem;
}

.campaigns-cards-error {
  text-align: center;
  grid-column: 1/-1;
}

.pagination {
  margin-top: auto;
}

@media (max-width: 900px) {
  .campaigns-cards {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }
}
</style>