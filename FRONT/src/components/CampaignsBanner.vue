<script setup lang="ts">
import InputField from "@/components/InputField.vue";
import MdiSearch from '~icons/mdi/search'
import Nav from "@/components/layouts/Nav.vue";
import {onMounted} from "vue";
import {useCategoryStore} from "@/stores/useCategoryStore.ts";

const categoryStore = useCategoryStore()

onMounted(() => {
  categoryStore.getCategories()
})
</script>

<template>

  <section class="campaigns-banner container">
    <h1 class="campaigns-banner-title">Vous êtes à la recherche d'une cagnotte</h1>
    <form class="campaigns-form" action="">
      <div class="campaigns-search">
        <MdiSearch width="32" height="47" class="search-icon"/>
        <InputField placeholder="Ex: construction d'un puit" size="large" class="campaigns-input"/>
      </div>
    </form>
    <Nav :links="categoryStore.categoriesNames" prefixClass="campaigns"/>
  </section>
</template>

<style>
.campaigns-banner {
  display: flex;
  flex-direction: column;
  align-items: center;
  row-gap: 3rem;
  background-color: var(--accent);
  padding-top: 2rem;
  padding-bottom: 1rem;
}

.campaigns-banner-title {
  margin-bottom: 0;
}

.campaigns-form {
  width: 45%;
}

.campaigns-search {
  display: flex;
  align-items: center;
  background-color: #fff;
  padding-left: .5rem;
  border: 3px solid var(--primary);
}

.campaigns-input {
  width: 100%;
}

.campaigns-nav {
  width: 100%;
}

.campaigns-list {
  display: flex;
  align-items: center;
  justify-content: space-around;
}

.campaigns-link {
  list-style: none;
  text-transform: capitalize;
  font-weight: 600;
}

.campaigns-cards {
  padding-top: 1rem;
}
</style>