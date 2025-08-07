<script setup lang="ts">
import Header from "@/components/layouts/Header.vue"
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import CampaignsBanner from "@/components/CampaignsBanner.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import {onMounted, watch} from "vue";
import Paginator, {PageState} from "primevue/paginator";
import Skeleton from 'primevue/skeleton';
import {useRoute, useRouter} from "vue-router";

const campaignStore = useCampaignStore();
const router = useRouter()
const route = useRoute()


// Fonction unique pour charger les campagnes
const loadCampaigns = async (pageParam: number | string | null = null, searchParam: string | null = null, categoryParam: string | null = null) => {
  // Utiliser les valeurs fournies ou récupérer depuis la route
  const page = pageParam ?? (route.query.page as string || 1);
  const search = searchParam ?? (route.query.search as string || "");
  const category = categoryParam ?? (route.params.category as string || "");

  await campaignStore.getCampaigns(page, search, category);
}

onMounted(async () => {
  // Charger les campagnes au montage, une seule fois
  await loadCampaigns();
})


const onPageChange = async (e: PageState) => {
  await campaignStore.setPage(Number(e.page + 1))
  let query: { page: number, search?: string } = {page: campaignStore.currentPage}
  if (campaignStore.currentSearch) {
    query = {...query, search: campaignStore.currentSearch}
  }
  await router.push({query})
}

watch(() => route.query, (newParams) => {
  if (campaignStore.currentPage.toString() !== (newParams.page as string || "1") ||
      campaignStore.currentSearch !== (newParams.search as string || "")) {
    loadCampaigns();
  }
})

watch(() => route.params.category, (newParams) => {
  // Réinitialiser la page à 1 lors d'un changement de catégorie
  loadCampaigns(1, campaignStore.currentSearch || "", newParams as string || "");

  // Mettre à jour l'URL pour refléter que nous sommes à la page 1
  if (campaignStore.currentPage !== 1) {
    let query: { page: number, search?: string } = {page: 1};
    if (campaignStore.currentSearch) {
      query = {...query, search: campaignStore.currentSearch};
    }
    router.push({query});
  }
})

</script>

<template>
  <Header/>
  <Main>
    <CampaignsBanner/>
    <section class="container">
      <div class="campaigns-cards" v-if="!campaignStore.error">
        <Skeleton v-for="n in 3 " :key="n" width="100%" height="300px" v-if="campaignStore.loading"></Skeleton>
        <CardCampaign v-for="campaign in campaignStore.campaigns.data" :key="campaign.id" :campaign="campaign"
                      v-else/>
      </div>
      <p class="campaigns-cards-error" v-else>{{ campaignStore.error }}</p>
    </section>
    <section class="pagination">
      <Paginator :first="(Number(campaignStore.currentPage) - 1) * campaignStore.itemsPerPage"
                 :rows="campaignStore.itemsPerPage"
                 :totalRecords="campaignStore.totalItems" @page="onPageChange"
                 v-if="!campaignStore.error"
      />
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
  margin-top: 2rem;
  font-size: 1.2rem;
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