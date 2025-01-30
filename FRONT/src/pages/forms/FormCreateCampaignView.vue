<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import QuillEditor from "@/components/QuillEditor.vue"
import Select from "primevue/select";
import FileUploader from "@/components/FileUploader.vue";
import {ref} from "vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import Message from "primevue/message";

const campaignStore = useCampaignStore();

const campaignData = ref({title: "", description: "", image: "", target_amount: "", category_id: 1});

const onSubmitFormCampaign = async () => {
  await campaignStore.createCampaign(campaignData.value)
}
</script>

<template>
  <Header/>
  <Main>
    <h1>Créer votre cagnotte</h1>
    <form class="form-container" @submit.prevent="onSubmitFormCampaign" enctype="multipart/form-data">
      <FileUploader v-model="campaignData.image"/>
      <InputField placeholder="Titre de la cagnotte" id="campaigntitle" title="Titre de la cagnotte"
                  v-model="campaignData.title"/>
      <Message severity="error" variant="simple" size="small" v-if="campaignStore.errorsFormCampaign?.title?.[0]">{{
          campaignStore.errorsFormCampaign?.title?.[0]
        }}
      </Message>
      <label for="campaignCategory">Choisissez une catégorie</label>
      <Select placeholder="Choisissez une catégorie" :options="['Animaux', 'Medecine']" labelId="campaignCategory"
              v-model="campaignData.category_id"/>
      <InputField placeholder="Ex: 10" id="campaignamount" title="Montant de la cagnotte" type="number"
                  v-model="campaignData.target_amount"/>
      <QuillEditor v-model="campaignData.description"/>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Lancer votre cagnotte" type="submit" :loading="campaignStore.loading"/>
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