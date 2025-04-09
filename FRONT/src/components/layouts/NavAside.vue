<script setup lang="ts">

import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useRouter} from "vue-router";
import {useToast} from "primevue/usetoast";
import ModalConfirm from "@/components/ModalConfirm.vue";
import {ref} from "vue"

const authStore = useAuthStore()
const router = useRouter()
const toast = useToast()
const modalConfirmLogout = ref<typeof ModalConfirm | null>(null)
const modalConfirmDelete = ref<typeof ModalConfirm | null>(null)

const logout = async () => {
  await authStore.logoutUser({})
  await router.push({name: "login"})
  toast.add({severity: 'success', summary: "Message de succès", detail: "Compte déconnecté avec succès", life: 5000});
}

const confirmLogout = () => {
  if (modalConfirmLogout.value) {
    modalConfirmLogout.value.callConfirm()
  }
}
const confirmDeleteAccount = () => {
  if (modalConfirmDelete.value) {
    modalConfirmDelete.value.callConfirm()
  }
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
      <ModalConfirm ref="modalConfirmLogout" :acceptFn="logout" group="logout">
        <li class="nav-aside-link">
          <RouterLink to="" role="button" @click="confirmLogout" label="test">Se déconnecter</RouterLink>
        </li>
      </ModalConfirm>
      <ModalConfirm ref="modalConfirmDelete" group="delete" message="Etes-vous de vouloir supprimer votre compte ?"
                    header="Suppression">
        <li class="nav-aside-link">
          <RouterLink to="" role="button" @click="confirmDeleteAccount">Supprimer mon compte</RouterLink>
        </li>
      </ModalConfirm>
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