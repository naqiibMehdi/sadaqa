<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import QuillEditor from "@/components/QuillEditor.vue"
import Select from "primevue/select";
import {useToast} from "primevue/usetoast";
import FileUploader from "@/components/FileUploader.vue";
import {onMounted, ref, watch} from "vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import Message from "primevue/message";
import {useRoute, useRouter} from "vue-router";
import {useCategoryStore} from "@/stores/useCategoryStore.ts";
import InputNumber from "primevue/inputnumber";
import Checkbox from "primevue/checkbox";

const router = useRouter()
const route = useRoute()
const campaignStore = useCampaignStore();
const categoryStore = useCategoryStore()
const toast = useToast()

const slug = route.params.slug
const id = route.params.id

const campaignData = ref<{
  title: string,
  description: string | HTMLElement
  image?: string | File,
  target_amount: number,
  category_id: string | number | null,
  is_anonymous: number
}>({
  title: "",
  description: "",
  image: "",
  target_amount: 0,
  category_id: null,
  is_anonymous: 0
});
const isAnonymous = ref<boolean | undefined>(campaignData.value.is_anonymous === 1)

onMounted(async () => {
  await campaignStore.getOneCampaign(slug as string, id as string)
  await categoryStore.getCategories()

})

watch(isAnonymous, (newValue) => {
  campaignData.value.is_anonymous = newValue ? 1 : 0
})

watch(() => campaignStore.campaign, (newCampaign) => {
  if (newCampaign) {
    campaignData.value = {
      title: newCampaign.title ?? "",
      description: newCampaign.description ?? "",
      image: "",
      target_amount: (newCampaign.target_amount ?? 0) / 100,
      category_id: newCampaign.category_id ?? null,
      is_anonymous: newCampaign.is_anonymous ? 1 : 0
    };
  }
  isAnonymous.value = newCampaign?.is_anonymous
});


const onSubmitFormCampaign = async () => {
  if (campaignData.value.image === "") {
    delete campaignData.value.image
  }
  await campaignStore.UpdateOneCampaign(slug as string, id as string, {
    ...campaignData.value,
    target_amount: campaignData.value.target_amount * 100
  });
  if (campaignStore.unauthorized) {
    toast.add({
      severity: 'error',
      summary: "Message d'erreur",
      detail: "Vous n'avez pas l'autorisation de modifier cette cagnotte\n",
      life: 5000
    });
    return
  }

  if (!campaignStore.errorsFormCampaign) {
    campaignData.value = {
      title: "",
      description: "",
      image: "",
      target_amount: 0,
      category_id: null,
      is_anonymous: 0
    }
    toast.add({severity: 'success', summary: "Message de succès", detail: campaignStore.successMessage, life: 5000});
    await router.push({name: "campaign", params: {slug: campaignStore.campaign?.slug, id: campaignStore.campaign?.id}});
  }
}
</script>

<template>
  <Header/>
  <Main>
    <h1>Mettez à jour votre cagnotte</h1>
    <form class="form-container" @submit.prevent="onSubmitFormCampaign" enctype="multipart/form-data">
      <FileUploader v-model="campaignData.image" :mainImage="campaignStore?.campaign?.url_image"
                    :key="campaignStore?.campaign?.id"/>
      <Message severity="error" variant="simple" size="small"
               v-if="campaignStore.errorsFormCampaign && typeof campaignStore.errorsFormCampaign?.image?.[0] === 'object' ">
        <p>{{ campaignStore.errorsFormCampaign?.image?.[0]?.max }}</p>
        <p>{{ campaignStore.errorsFormCampaign?.image?.[0]?.mimes }}</p>
      </Message>
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
        <label for="campaignAmount">Modifier le montant total à atteindre</label>
        <InputNumber
            v-model="campaignData.target_amount"
            id="campaignAmount"
            inputId="currency-fr"
            mode="currency"
            currency="EUR"
            locale="fr-FR"
            :minFractionDigits="0"
            :maxFractionDigits="0"
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
        <QuillEditor v-model="campaignData.description" :key="campaignStore?.campaign?.id"/>
        <Message severity="error" variant="simple" size="small"
                 v-if="campaignStore.errorsFormCampaign?.target_amount?.[0]">
          {{ campaignStore.errorsFormCampaign?.description?.[0] }}
        </Message>
      </div>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Modifier votre cagnotte" type="submit" :loading="campaignStore.loading"/>
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