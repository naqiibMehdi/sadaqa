<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import NavAside from "@/components/layouts/NavAside.vue";
import Main from "@/components/layouts/Main.vue";
import Footer from "@/components/layouts/Footer.vue";
import Divider from 'primevue/divider';
import {useRoute} from "vue-router";
import {ref, watch} from "vue";

const route = useRoute()

const title = ref("Mon profil")

const updateRouteInfo = () => {
  switch (route.path) {
    case "/account/profil":
      title.value = "Mon profil"
      break
    case "/account/address":
      title.value = "Mon adresse"
      break
    case "/account/bank-account":
      title.value = "Mes coordonnées bancaires"
      break
  }
}

watch(() => route.path, updateRouteInfo)

</script>

<template>
  <Header/>
  <Main>
    <h1>{{ title }}</h1>
    <section class="account">
      <aside class="account-nav-aside">
        <NavAside/>
      </aside>
      <Divider layout="vertical"/>
      <RouterView></RouterView>
    </section>
  </Main>
  <Footer/>
</template>

<style scoped>
.account {
  max-width: 1200px;
  width: 100%;
  display: grid;
  grid-template-columns: minmax(min-content, 240px) max-content  minmax(300px, 1fr);
  column-gap: 2rem;
}

.account-nav-aside {
  align-self: center;
  justify-self: center;
  width: 100%;
}
</style>