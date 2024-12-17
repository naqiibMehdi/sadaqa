<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
import QuillEditor from "@/components/QuillEditor.vue"
import Select from "primevue/select";
import FileUploader from "@/components/FileUploader.vue";


</script>

<template>
  <Header/>
  <Main>
    <h1>Créer votre cagnotte</h1>
    <form class="form-container">
      <FileUploader/>
      <InputField placeholder="Titre de la cagnotte" id="campaigntitle" title="Titre de la cagnotte"/>
      <label for="campaignCategory">Choisissez une catégorie</label>
      <Select placeholder="Choisissez une catégorie" :options="['Animaux', 'Medecine']" labelId="campaignCategory"/>
      <InputField placeholder="Ex: 10" id="campaignamount" title="Montant de la cagnotte"/>
      <QuillEditor/>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Lancer votre cagnotte"/>
      </div>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formConnexion-buttons-list {
  display: flex;
  flex-direction: column;
  row-gap: 1rem;
}


.formConnexion-buttons-list button {
  width: 100%;
  font-size: 1.125rem;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>