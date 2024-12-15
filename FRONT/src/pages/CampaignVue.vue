<script setup lang="ts">
import Header from "@/components/Header.vue"
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
</script>

<template>
  <Header/>
  <InputField placeholder="Email"/>
  <CustomButton label="Connexion" :outline="true"/>
</template>

<style scoped>

</style>