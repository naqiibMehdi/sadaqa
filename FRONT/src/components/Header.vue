<script setup lang="ts">
import {RouterLink} from "vue-router";
</script>

<template>
  <header class="header">
    <div class="container">
      <p class="header-title">Sadaqa</p>
      <nav class="header-nav">
        <ul class="header-list">
          <li class="header-item">Rechercher une cagnotte</li>
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

.header-item:hover {
  color: var(--primary);
  cursor: pointer;
}

</style>