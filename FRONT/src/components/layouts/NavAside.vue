<script setup lang="ts">

import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useRouter} from "vue-router";
import {useToast} from "primevue/usetoast";

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
  <nav class="nav-aside">
    <ul class="nav-aside-list">
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'profil'}" active-class="active-link">Mon profil</RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'address'}" active-class="active-link">Mon adresse</RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink :to="{name: 'iban'}" active-class="active-link">Coordonnée bancaire</RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink to="" role="button" @click="logout">Se déconnecter</RouterLink>
      </li>
      <li class="nav-aside-link">
        <RouterLink to="">Supprimer mon compte</RouterLink>
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

.nav-aside-link:last-child a {
  color: red;
}

.nav-aside-link:hover:last-child a {
  text-decoration: underline;
}

.nav-aside-link:hover {
  background-color: var(--text5);
}


.active-link {
  color: var(--accent)
}
</style>