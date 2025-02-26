<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import QuillEditor from "@/components/QuillEditor.vue"
import Select from "primevue/select";
import FileUploader from "@/components/FileUploader.vue";
import {onMounted, ref, watch} from "vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import Message from "primevue/message";
import {useRoute, useRouter} from "vue-router";
import {useCategoryStore} from "@/stores/useCategoryStore.ts";

const router = useRouter()
const route = useRoute()
const campaignStore = useCampaignStore();
const categoryStore = useCategoryStore()

const slug = route.params.slug
const id = route.params.id

const campaignData = ref<{
  title: string,
  description: string | HTMLElement
  image: string | File,
  target_amount: string | number | null,
  category_id: string | number | null
}>({
  title: campaignStore?.campaign?.title ?? "",
  description: campaignStore?.campaign?.description ?? "",
  image: "",
  target_amount: ((campaignStore?.campaign?.target_amount ?? 0) / 100).toString(),
  category_id: campaignStore?.campaign?.category_id ?? null
});


onMounted(async () => {
  await categoryStore.getCategories()
  await campaignStore.getOneCampaign(slug as string, id as string)

})

watch(() => campaignStore.campaign, (newCampaign) => {
  if (newCampaign) {
    campaignData.value = {
      title: newCampaign.title ?? "",
      description: newCampaign.description ?? "",
      image: "",
      target_amount: ((newCampaign.target_amount ?? 0) / 100).toString(),
      category_id: newCampaign.category_id ?? null
    };
  }
});


const onSubmitFormCampaign = async () => {
  console.log(campaignData.value)
  const response = await campaignStore.createCampaign({
    ...campaignData.value,
    target_amount: Number(campaignData.value.target_amount) * 100
  });

  if (!campaignStore.errorsFormCampaign) {
    campaignData.value = {
      title: "",
      description: "",
      image: "",
      target_amount: null,
      category_id: null
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
      <FileUploader v-model="campaignData.image" :mainImage="campaignStore?.campaign?.url_image"/>
      <div class="input-error">
        <InputField placeholder="Titre de la cagnotte" id="campaigntitle" title="Titre de la cagnotte"
                    v-model="campaignData.title"
                    :invalid="campaignStore.errorsFormCampaign && campaignStore.errorsFormCampaign?.title?.[0] !== '' "/>
        <Message severity="error" variant="simple" size="small" v-if="campaignStore.errorsFormCampaign?.title?.[0]">
          {{ campaignStore.errorsFormCampaign?.title?.[0] }}
        </Message>
      </div>

      <label for="campaignCategory">Choisissez une catégorie</label>
      <Select placeholder="Choisissez une catégorie"
              :options="categoryStore.categories"
              optionLabel="name"
              optionValue="id"
              labelId="campaignCategory"
              v-model="campaignData.category_id"
              :invalid="((campaignStore.errorsFormCampaign && campaignStore.errorsFormCampaign?.category_id?.[0] !== '') as boolean)"
      />
      <Message severity="error" variant="simple" size="small"
               v-if="campaignStore.errorsFormCampaign?.category_id?.[0]">
        {{ campaignStore.errorsFormCampaign?.category_id?.[0] }}
      </Message>

      <div class="input-error">
        <InputField placeholder="Ex: 10" id="campaignamount" title="Montant de la cagnotte" type="number"
                    v-model="campaignData.target_amount as string"
                    :invalid="campaignStore.errorsFormCampaign && campaignStore.errorsFormCampaign?.target_amount?.[0] !== '' "/>
        <Message severity="error" variant="simple" size="small"
                 v-if="campaignStore.errorsFormCampaign?.target_amount?.[0]">
          {{ campaignStore.errorsFormCampaign?.target_amount?.[0] }}
        </Message>
      </div>
      <div class="input-error">
        <QuillEditor v-model="campaignData.description"/>
        <Message severity="error" variant="simple" size="small"
                 v-if="campaignStore.errorsFormCampaign?.target_amount?.[0]">
          {{ campaignStore.errorsFormCampaign?.description?.[0] }}
        </Message>
      </div>
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