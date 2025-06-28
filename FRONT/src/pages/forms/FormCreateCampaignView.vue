<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import QuillEditor from "@/components/QuillEditor.vue"
import Select from "primevue/select";
import FileUploader from "@/components/FileUploader.vue";
import Checkbox from 'primevue/checkbox';
import {onMounted, ref, watch} from "vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import Message from "primevue/message";
import {useRouter} from "vue-router";
import {useCategoryStore} from "@/stores/useCategoryStore.ts";
import InputNumber from "primevue/inputnumber";

const router = useRouter()
const campaignStore = useCampaignStore();
const categoryStore = useCategoryStore()


const campaignData = ref<{
  title: string,
  description: string,
  image: string,
  target_amount: number,
  category_id: number | string | null,
  is_anonymous: number
}>({
  title: "",
  description: "",
  image: "",
  target_amount: 0,
  category_id: null,
  is_anonymous: 0
});
const isAnonymous = ref(campaignData.value.is_anonymous === 1)

onMounted(() => {
  categoryStore.getCategories()
})

watch(isAnonymous, (newValue) => {
  campaignData.value.is_anonymous = newValue ? 1 : 0
})

const onSubmitFormCampaign = async () => {
  const response = await campaignStore.createCampaign({
    ...campaignData.value,
    target_amount: campaignData.value.target_amount * 100
  });

  if (!campaignStore.errorsFormCampaign) {
    campaignData.value = {
      title: "",
      description: "",
      image: "",
      target_amount: 0,
      category_id: null,
      is_anonymous: 0
    }

    await router.push({name: "campaign", params: {slug: response.data.slug, id: response.data.id}});
  }
}
</script>

<template>
  <Header/>
  <Main>
    <h1>Créer votre cagnotte</h1>
    <form class="form-container" @submit.prevent="onSubmitFormCampaign" enctype="multipart/form-data">
      <FileUploader v-model="campaignData.image"/>
      <div class="input-error">
        <InputField placeholder="Titre de la cagnotte" id="campaigntitle" title="Titre de la cagnotte"
                    v-model="campaignData.title"
                    :invalid="(campaignStore.errorsFormCampaign?.title && campaignStore.errorsFormCampaign?.title?.[0] !== '') as boolean"/>
        <Message severity="error" variant="simple" size="small" v-if="campaignStore.errorsFormCampaign?.title?.[0]">
          {{ campaignStore.errorsFormCampaign?.title?.[0] }}
        </Message>
      </div>

      <label for="campaignCategory">Choisissez une catégorie</label>
      <Select
          placeholder="Choisissez une catégorie"
          :options="categoryStore.categories"
          optionLabel="translate_name"
          optionValue="id"
          labelId="campaignCategory"
          v-model="campaignData.category_id"
          :invalid="((campaignStore.errorsFormCampaign?.category_id && campaignStore.errorsFormCampaign?.category_id?.[0] !== '') as boolean)"
      />
      <Message severity="error" variant="simple" size="small"
               v-if="campaignStore.errorsFormCampaign?.category_id?.[0]">
        {{ campaignStore.errorsFormCampaign?.category_id?.[0] }}
      </Message>

      <div class="input-error">
        <label for="campaignAmount">Saisissez un montant</label>
        <InputNumber
            v-model="campaignData.target_amount"
            id="campaignAmount"
            inputId="currency-fr"
            mode="currency"
            currency="EUR"
            locale="fr-FR"
            :minFractionDigits="0"
            :maxFractionDigits="0"
            size="large"
            :invalid="((campaignStore.errorsFormCampaign?.target_amount && campaignStore.errorsFormCampaign?.target_amount?.[0] !== '') as boolean)"
        />

        <Message severity="error" variant="simple" size="small"
                 v-if="campaignStore.errorsFormCampaign?.target_amount?.[0]">
          {{ campaignStore.errorsFormCampaign?.target_amount?.[0] }}
        </Message>
      </div>

      <div class="input-checkbox">
        <Checkbox
            v-model="isAnonymous"
            inputId="is_anonymous"
            binary
        />
        <label for="is_anonymous">Cagnotte anonyme</label>
      </div>

      <div class="input-error">
        <QuillEditor v-model="campaignData.description"/>
        <Message severity="error" variant="simple" size="small"
                 v-if="campaignStore.errorsFormCampaign?.target_amount?.[0]">
          {{ campaignStore.errorsFormCampaign?.description?.[0] }}
        </Message>
      </div>
      <div class="formConnexion-buttons-list">
        <CustomButton
            label="Lancer votre cagnotte"
            type="submit"
            :loading="campaignStore.loading"
            :disabled="campaignStore.loading"
        />
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