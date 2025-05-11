<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import homeDonation from "@/assets/home-donation.svg"
import hand from "@/assets/hand.svg"
import gift from "@/assets/gift.svg"
import CardCampaignHome from "@/components/CardCampaignHome.vue";
</script>

<template>
  <Header/>
  <Main>
    <div class="container">
      <section class="home home-first-section">
        <img :src="homeDonation" alt="Image illustrant des personnes faisant un don" class="home-first-section_image">
        <div class="home-sub_first_section">
          <h1 class="home-sub_title">Faites votre premier pas en faisant un <span
              class="home-sub_span">don</span> pour un <span
              class="home-sub_span">projet</span> ou une
            <span class="home-sub_span">association</span></h1>
          <RouterLink :to="{name: 'campaigns'}" class="primary-button home-sub_btn">Je finance une cagnotte</RouterLink>
        </div>
      </section>
      <section class="home home-second-section">
        <h2 class="home-second-section_title">Vous pouvez cotiser pour...</h2>
        <div class="home-sub_second_section">
          <div class="home-sub_second_section_container">
            <img :src="gift" alt="image représentant un cadeau" class="home-sub_second_section_container_image">
            <h3>Un pot commun</h3>
            <p class="home-sub_second_section_text">Un pot commun, pour aider un ami, une famille, à financer un
              voyage...</p>
          </div>
          <div class="home-sub_second_section_container">
            <img :src="hand" alt="image représentant une main tenant un coeur"
                 class="home-sub_second_section_container_image">
            <h3>Un projet associatif</h3>
            <p class="home-sub_second_section_text">Soutenir un projet associatif dans le domaine de la santé, de
              l'éducation...</p>
          </div>
        </div>
      </section>
      <section class="home-third-section">
        <h3>Beaucoup de générosité et de solidarité !</h3>
        <div class="home-third-section_campaigns">
          <CardCampaignHome/>
          <CardCampaignHome/>
          <CardCampaignHome/>
        </div>
      </section>
    </div>
  </Main>
  <Footer/>
</template>


<style scoped>
.home-first-section {
  display: flex;
  align-items: center;
  gap: 1.6rem;
}

.home-first-section_image {
  max-width: 800px;
}

.home-sub_first_section {
  display: flex;
  flex-direction: column;
  max-width: 400px;
}

.home-sub_title {
  margin-bottom: 1rem;
}

.home-sub_span {
  background: linear-gradient(120deg, var(--primary), var(--accent));
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.home-sub_btn {
  text-align: center;
  font-size: 1.2rem;
}

.home-sub_btn:hover {
  background-color: var(--accent);
}

.home-second-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.6rem;
  background-color: var(--secondary20);
  padding-block: 40px;
  border-radius: 10px;
}

.home-sub_second_section {
  display: flex;
  align-items: center;
  gap: 1.6rem;
}

.home-sub_second_section_container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .6rem;
  max-width: 400px;
}

.home-sub_second_section_container_image {
  width: 120px;
  height: 120px;
}

.home-sub_second_section_text {
  text-align: center;
}

.home-third-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.6rem;
  padding-block: 40px;
}

.home-third-section_campaigns {
  display: grid;
  grid-template-columns: repeat(3, 300px);
  justify-content: center;
  gap: 1.6rem;
}

</style>