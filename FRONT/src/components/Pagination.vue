<script setup lang="ts">
import Paginator, {PageState} from "primevue/paginator";

const emit = defineEmits<{
  (event: "test", payload: { PageState })
}>()


const onChangePage = (event: PageState) => {
  emit("test", event)
}

</script>

<template>
  <section class="pagination">
    <Paginator :rows="9" :totalRecords="20" @page="onChangePage"></Paginator>
  </section>
</template>

<style scoped>
.pagination {
  margin-top: 2rem;
}

</style>