<script setup lang="ts">
import Toast from "primevue/toast";
import {onMounted} from "vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useUserStore} from "@/stores/useUserStore.ts";

const authStore = useAuthStore()
const userStore = useUserStore()

onMounted(() => {
  authStore.initializeAuth()
  userStore.initialiseUser()
})
</script>

<template>
  <Toast position="bottom-center"/>
  <RouterView/>
</template>

<style scoped>
</style>
