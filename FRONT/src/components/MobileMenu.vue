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
    <nav aria-label="menu navigation mobile">
      <ul class="header-list" v-if="isToken">
        <li class="header-item">
          <RouterLink :to="{name: 'home'}" aria-label="page d'accueil">Accueil</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'campaigns'}" aria-label="afficher les cagnottes">Rechercher une cagnotte</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'dashboard'}" aria-label="accéder au dashboard">Dashboard</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'createcampaign'}" aria-label="accéder à la page de création d'une cagnotte">Créer une
            cagnotte
          </RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'profil'}" aria-label="accéder au compte utilisateur">Mon compte</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'address'}" active-class="active-link" aria-label="accéder à l'adresse postale">Mon
            adresse
          </RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'iban'}" active-class="active-link" aria-label="accéder à l'IBAN">Coordonnée
            bancaire
          </RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'recovery'}" active-class="active-link" aria-label="accéder aux virements">Mes
            virements
          </RouterLink>
        </li>
        <li class="nav-aside-link">
          <RouterLink to="" role="button" @click="logout" label="test" aria-label="se déconnecter du compte">Se
            déconnecter
          </RouterLink>
        </li>
      </ul>

      <ul class="header-list" v-else>
        <li class="header-item">
          <RouterLink :to="{name: 'home'}" aria-label="page d'accueil">Accueil</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'login'}" aria-label="page de connexion">Connexion</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'register'}" aria-label="page d'inscription">S'inscrire</RouterLink>
        </li>
        <li class="header-item">
          <RouterLink :to="{name: 'campaigns'}" aria-label="afficher les cagnottes">Rechercher une cagnotte</RouterLink>
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
