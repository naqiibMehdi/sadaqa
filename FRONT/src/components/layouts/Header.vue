<script setup lang="ts">
import {RouterLink} from "vue-router";
import {useAuthStore} from "@/stores/useAuthStore.ts";

const authStore = useAuthStore();
</script>

<template>
  <header class="header">
    <div class="container">
      <p class="header-title">Sadaqa</p>
      <nav class="header-nav">
        <ul class="header-list" v-if="authStore.token">
          <li class="header-item">
            <RouterLink :to="{name: 'dashboard'}">Dashboard</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'createcampaign'}">Créer une cagnotte</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'profil'}">Mon compte</RouterLink>
          </li>
        </ul>

        <ul class="header-list" v-if="!authStore.token">
          <li class="header-item">
            <RouterLink :to="{name: 'campaigns'}">Recherche une cagnotte</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'login'}">Connexion</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'register'}" class="primary-button">S'inscrire</RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<style scoped>

header {
  display: flex;
  justify-content: center;
  height: 60px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header-nav {
  width: 560px;
}

.header-list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  list-style: none;
}

.header-item:last-child a:hover {
  background-color: var(--accent);
  cursor: pointer;
}

</style>