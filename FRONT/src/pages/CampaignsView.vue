<script setup lang="ts">
import Header from "@/components/Header.vue"
import Footer from "@/components/Footer.vue";
import Main from "@/components/Main.vue";
import CampaignsBanner from "@/components/CampaignsBanner.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import Pagination from "@/components/Pagination.vue";
import {ref} from "vue";


const first = ref({})
const tab = ref<object[]>([
      {
        id: 1,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/150/100" // Miniature
      },
      {
        id: 2,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/200/150" // Miniature
      },
      {
        id: 3,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/300/200" // Miniature
      },
      {
        id: 4,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/400/300" // Miniature
      },
      {
        id: 5,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/100/75" // Miniature
      },
      {
        id: 6,
        imageUrl: "https://picsum.photos/800/600", // Image de base
        thumbnailUrl: "https://picsum.photos/120/90" // Miniature
      },
    ]
)

const te = (o) => {
  first.value = o
}


</script>

<template>
  <Header/>
  <Main>
    <CampaignsBanner/>
    <section class="container campaigns-cards">
      <CardCampaign v-for="baseImage in tab" :baseUrl="baseImage.imageUrl" :key="baseImage.id"/>
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