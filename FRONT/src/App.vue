<script setup lang="ts">
import Toast from "primevue/toast";
import {onMounted} from "vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";

const authStore = useAuthStore()

onMounted(() => {
  authStore.initializeAuth()
})
</script>

<template>
  <Toast position="bottom-center"/>
  <RouterView/>
</template>

<style scoped>
</style>
