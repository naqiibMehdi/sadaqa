<script setup lang="ts">
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
        <RouterLink to="">Se déconnecter</RouterLink>
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