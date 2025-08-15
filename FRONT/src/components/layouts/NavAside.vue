<script setup lang="ts">

import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useRouter} from "vue-router";
import {useToast} from "primevue/usetoast";
import Loader from "@/components/Loader.vue";

const authStore = useAuthStore()
const router = useRouter()
const toast = useToast()

const logout = async () => {
  await authStore.logoutUser({})
  await router.push({name: "login"})
  toast.add({severity: 'success', summary: "Message de succès", detail: "Compte déconnecté avec succès", life: 5000});
}
</script>

<template>
  <Loader v-if="authStore.loading"/>
  <nav class="nav-aside">
    <ul class="nav-aside-list">
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'profil'}" active-class="active-link" aria-label="accéder à votre profile">Mon profil
        </RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'address'}" active-class="active-link" aria-label="accéder à votre adresse postale">Mon
          adresse
        </RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'iban'}" active-class="active-link" aria-label="accéder à votre IBAN">Coordonnée
          bancaire
        </RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'recovery'}" active-class="active-link" aria-label="accéder à vos virements">Mes
          virements
        </RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink to="" role="button" @click="logout" label="test" aria-label="se déconnecter de votre compte">Se
          déconnecter
        </RouterLink>
      </li>
    </ul>
  </nav>


</template>

<style scoped>
.nav-aside-list li {
  list-style: none;
  padding-block: 1rem;
  padding-inline: .6rem;
}

.nav-aside-link:hover {
  background-color: var(--text5);
}


.active-link {
  color: var(--accent)
}
</style>