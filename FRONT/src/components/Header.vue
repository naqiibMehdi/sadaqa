<script setup lang="ts">

</script>

<template>
  <header class="header">
      <div class="container">
        <p class="header-title">Sadaqa</p>
        <nav class="header-nav">
          <ul class="header-list">
            <li class="header-item">Rechercher une cagnotte</li>
            <li class="header-item">Connexion</li>
            <li class="header-item"><a href="" class="primary-button">Créer une cagnotte</a></li>
          </ul>
        </nav>
      </div>
  </header>
</template>

<style scoped>

header{
  display: flex;
  justify-content: center;
  height: 60px;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.header .container{
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0px 8px;
}

.header-nav{
  width: 560px;
}

.header-list{
  display: flex;
  justify-content: space-around ;
  align-items: center;
  list-style: none;
}

.header-item:hover{
  color: var(--primary);
  cursor: pointer;
}

</style>