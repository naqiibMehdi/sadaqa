<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/Footer.vue";
import IcBaselinePhotoCamera from '~icons/ic/baseline-photo-camera'
import {ref} from "vue";
import Select from "primevue/select";

let url = ref<string>("https://placehold.co/600x400")
</script>

<template>
  <Header/>
  <Main>
    <form class="form-container">
      <div class="formCreateCampaign-banner-upload">
        <input type="file" hidden="">
        <div v-if="!url" style="display: flex; flex-direction: column; align-items: center">
          <IcBaselinePhotoCamera width="32" height="32"/>
          <p>Joindre une image principale</p>
        </div>
        <div v-else class="formCreateCampaign-banner-upload__bgImage"
             :style="{backgroundImage: `url(${url})`}">

        </div>
      </div>
      <InputField placeholder="Titre de la cagnotte" id="campaigntitle" title="Titre de la cagnotte"/>
      <label for="campaignCategory">Choisissez une catégorie</label>
      <Select placeholder="Choisissez une catégorie" :options="['Animaux', 'Medecine']" labelId="campaignCategory"/>
      <InputField placeholder="Ex: 10" id="campaignamount" title="Montant de la cagnotte"/>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Lancer votre cagnotte"/>
      </div>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formCreateCampaign-banner-upload {
  position: relative;
  height: 200px;
  border: 5px solid var(--text5);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 0.3rem;
}

.formCreateCampaign-banner-upload__bgImage {
  position: absolute;
  content: "";
  inset: 0;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.formCreateCampaign-banner-upload:hover {
  cursor: pointer;
  background-color: var(--text5);
}

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