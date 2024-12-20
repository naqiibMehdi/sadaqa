<script setup lang="ts">
import Header from "@/components/Header.vue"
import Footer from "@/components/Footer.vue";
import Main from "@/components/Main.vue";
import CardCampaign from "@/components/CardCampaign.vue";
import ParticipantBanner from "@/components/ParticipantBanner.vue";
</script>

<template>
  <Header/>
  <Main>
    <section class="campaign container">
      <h1 class="campaign-title">Titre de la cagnotte</h1>
      <div class="campaign-body">
        <section class="campaign-card-profil">
          <CardCampaign/>
        </section>
        <section class="campaign-card-description">
          <p>
            Lorem ipsum odor amet, consectetuer adipiscing elit. Consequat morbi interdum parturient tortor dictum
            tincidunt
            posuere. Mattis per dui convallis elementum etiam mollis non sapien. Elit nibh dictum interdum gravida mi;
            diam
            platea scelerisque. Curae himenaeos magna libero iaculis cubilia. Integer nisi auctor class sed congue.
            Aliquam
            mus himenaeos mi purus rutrum ultrices. Parturient in facilisis fusce orci dapibus ante diam? Class natoque
            venenatis neque hendrerit interdum mollis.
          </p>

          
        </section>
      </div>
      <div class="campaign-footer">
        <h2>Liste des participants</h2>
        <ParticipantBanner/>
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

.campaign-body {
  display: grid;
  grid-template-columns: minmax(250px, 1fr) 2fr;
  column-gap: 1.3rem;
}

.campaign-footer {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  width: 60%;
}


</style>