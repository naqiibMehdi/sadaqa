<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import Footer from "@/components/layouts/Footer.vue";
import CustomButton from "@/components/CustomButton.vue";
import MdiEdit from "~icons/mdi/edit"
import MdiLock from "~icons/mdi/lock"
import ParticipantBanner from "@/components/ParticipantBanner.vue";
</script>

<template>
  <Header/>
  <Main>
    <section class="container dashboard">
      <h1 class="dashboard-title">Votre Dashboard</h1>
      <div class="dashboard-list-campaigns">
        <article class="dashboard-campaign">
          <div class="dashboard-campaign-img">
            <img src="https://picsum.photos/800/600" alt="image principale de la cagnotte"/>
          </div>
          <div class="dashboard-campaign-infos">
            <h2>titre de la cagnotte</h2>
            <div class="dashboard-campaign-subinfos">
              <p>10000 €</p>
              <p>40 participants</p>
            </div>
            <div class="dashboard-campaign-list-btn">
              <CustomButton label="modifier" :customComponent="MdiEdit"/>
              <CustomButton label="clôturer" :customComponent="MdiLock"/>
            </div>
          </div>
        </article>
      </div>
    </section>
    <section class="container participants">
      <h2 class="dashboard-second-title">Donateurs récents:</h2>
      <ParticipantBanner/>
      <ParticipantBanner/>
    </section>
  </Main>
  <Footer/>
</template>

<style scoped>

.dashboard-list-campaigns article:not(:last-child) {
  margin-bottom: 1.8rem;
}


.dashboard-campaign {
  display: grid;
  grid-template-columns: repeat(2, minmax(200px, 1fr));
  grid-gap: 1rem;
  place-items: center stretch;
  height: 360px;
  padding: 0 1rem;
  border-radius: 10px;
  background-color: var(--secondary20);
}

.dashboard-title, .dashboard-second-title {
  text-align: center;
  margin-top: 1.5rem;
}

.dashboard-second-title {
  margin-bottom: 3.5rem;
}

.dashboard-campaign-img {
  height: 300px;
  border-radius: 10px;
}


.dashboard-campaign-img img {
  width: 100%;
  display: block;
  height: inherit;
  border-radius: 10px;
  aspect-ratio: 16 / 9;
  object-fit: cover;
}

.dashboard-campaign-infos {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.dashboard-campaign-subinfos p {
  font-size: 1.175rem;
}


.dashboard-campaign-subinfos,
.dashboard-campaign-list-btn {
  width: 100%;
  display: flex;
  justify-content: space-around;
  gap: 1rem;
}

.dashboard-campaign-list-btn button {
  width: 50%;
  font-size: 1.125rem;
}
</style>