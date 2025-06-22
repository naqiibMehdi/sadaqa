<script setup lang="ts">
import {RouterLink, useRoute} from "vue-router";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import logo from "@/assets/title-accent.svg"
import MobileMenu from "@/components/MobileMenu.vue";
import {computed, onMounted, onUnmounted, ref, watch} from "vue";


const route = useRoute()
const authStore = useAuthStore();
const isMenuOpen = ref(false)
const isMobile = ref(window.innerWidth < 768)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const updateWidth = () => {
  isMobile.value = window.innerWidth < 768
  if (!isMobile.value) {
    isMenuOpen.value = false
  }
}
const isToken = ref(authStore.token || localStorage.getItem('token'))

const animateHamburger = computed(() => isMenuOpen.value ? "open" : "")

onMounted(() => {
  window.addEventListener("resize", updateWidth)
})

onUnmounted(() => {
  window.removeEventListener("resize", updateWidth)
})

watch(() => route.path, () => {
  isMenuOpen.value = false
})

</script>

<template>
  <header class="header">
    <div class="container">
      <RouterLink :to="{name: 'home'}">
        <img :src="logo" alt="logo principal du site web" class="header-logo">
      </RouterLink>
      <div v-if="isMobile" class="hamburger" :class="animateHamburger" @click="toggleMenu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
      <nav class="header-nav" v-else>
        <ul class="header-list" v-if="isToken">
          <li class="header-item">
            <RouterLink :to="{name: 'campaigns'}" active-class="active-link">Rechercher une cagnotte</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'dashboard'}" active-class="active-link">Dashboard</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'createcampaign'}" active-class="active-link">Créer une cagnotte</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'profil'}" active-class="active-link">Mon compte</RouterLink>
          </li>
        </ul>

        <ul class="header-list" v-else>
          <li class="header-item">
            <RouterLink :to="{name: 'campaigns'}" active-class="active-link">Rechercher une cagnotte</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'login'}" active-class="active-link">Connexion</RouterLink>
          </li>
          <li class="header-item">
            <RouterLink :to="{name: 'register'}" class="primary-button">S'inscrire</RouterLink>
          </li>
        </ul>
      </nav>
    </div>
    <MobileMenu :is-menu-open="isMenuOpen"/>
  </header>
</template>

<style scoped>

header {
  display: flex;
  justify-content: center;
  height: 60px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding-inline: 10px;
}

.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header-logo {
  width: 100px;
  height: 38px;
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


.hamburger {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 20px;
  cursor: pointer;
  transition: transform 0.3s ease, width 0.3s ease, left 0.3s ease;
}

.line {
  width: 25px;
  height: 3px;
  background-color: black;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.hamburger.open .line:nth-child(1) {
  transform: rotate(45deg) translate(7px, 6px);
}

.hamburger.open .line:nth-child(2) {
  opacity: 0;
}

.hamburger.open .line:nth-child(3) {
  transform: rotate(-45deg) translate(7px, -6px);
}

.active-link {
  color: var(--accent);
}

</style>