<script setup lang="ts">
import Header from "@/components/Header.vue"
import InputField from "@/components/InputField.vue";
import Button from "@/components/Button.vue"
</script>

<template>
  <Header/>
  <InputField placeholder="Email"/>
  <Button label="Connexion" :outline="true"/>
</template>

<style scoped>

</style>