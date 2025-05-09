<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
</script>
<template>
  <Header/>
  <Main>
    <h1 class="error-title">Oups! Erreur 404</h1>
    <RouterLink :to="{name: 'home'}" class="error-link">Revenir à la page d'accueil</RouterLink>
  </Main>
  <Footer/>
</template>


<style scoped>
.error-title {
  color: var(--primary);
  font-size: 2.8rem;
}

.error-link {
  color: var(--accent);
  text-decoration: underline;
}
</style>