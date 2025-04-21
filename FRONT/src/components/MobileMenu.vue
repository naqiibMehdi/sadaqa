<script setup lang="ts">
import {defineProps} from 'vue';
import {RouterLink} from 'vue-router';
import {useAuthStore} from '@/stores/useAuthStore.ts';

defineProps({
  isMenuOpen: Boolean
});

const authStore = useAuthStore();
</script>

<template>
  <div :class="['mobile-menu', { 'menu-open': isMenuOpen }]">
    <nav>
      <ul class="header-list" v-if="authStore.token">
        <li class="header-item">
          <RouterLink :to="{name: 'campaigns'}">Rechercher une cagnotte</RouterLink>
        </li>
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

      <ul class="header-list" v-else>
        <li class="header-item">
          <RouterLink :to="{name: 'campaigns'}">Rechercher une cagnotte</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'login'}">Connexion</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'register'}">S'inscrire</RouterLink>
        </li>
      </ul>
    </nav>
  </div>
</template>

<style scoped>
.mobile-menu {
  display: flex;
  flex-direction: column;
  background-color: var(--background);
  position: fixed;
  top: 60px;
  right: 0;
  width: max-content;
  height: calc(100vh - 60px);
  transform: translateX(100%);
  transition: transform 0.3s ease;
  border-left: 1px solid rgba(0, 0, 0, 0.1);
  z-index: 1000;
}

.menu-open {
  transform: translateX(0);
}

.mobile-menu ul {
  list-style: none;
  padding: 0;
}

.mobile-menu li {
  padding: 1rem 20px;
}

.mobile-menu a {
  text-decoration: none;
}

.mobile-menu li:hover {
  background-color: var(--text5);
}

</style>
