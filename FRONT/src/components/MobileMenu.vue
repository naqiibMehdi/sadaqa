<script setup lang="ts">
import {RouterLink, useRouter} from 'vue-router';
import {useAuthStore} from '@/stores/useAuthStore.ts';
import {useToast} from "primevue/usetoast";
import {ref} from "vue";

defineProps({
  isMenuOpen: Boolean
});

const authStore = useAuthStore();
const router = useRouter()
const toast = useToast()
const isToken = ref(authStore.token || localStorage.getItem('token'))
const logout = async () => {
  await authStore.logoutUser({})
  await router.push({name: "login"})
  toast.add({severity: 'success', summary: "Message de succès", detail: "Compte déconnecté avec succès", life: 5000});
}
</script>

<template>
  <div :class="['mobile-menu', { 'menu-open': isMenuOpen }]">
    <nav>
      <ul class="header-list" v-if="isToken">
        <li class="header-item">
          <RouterLink :to="{name: 'home'}">Accueil</RouterLink>
        </li>
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
        <li class="header-item">
          <RouterLink :to="{name: 'address'}" active-class="active-link">Mon adresse</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'iban'}" active-class="active-link">Coordonnée bancaire</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'recovery'}" active-class="active-link">Mes virements</RouterLink>
        </li>
        <li class="nav-aside-link">
          <RouterLink to="" role="button" @click="logout" label="test">Se déconnecter</RouterLink>
        </li>
      </ul>

      <ul class="header-list" v-else>
        <li class="header-item">
          <RouterLink :to="{name: 'home'}">Accueil</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'login'}">Connexion</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'register'}">S'inscrire</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'campaigns'}">Rechercher une cagnotte</RouterLink>
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
