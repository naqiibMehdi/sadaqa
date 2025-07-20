<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import Footer from "@/components/layouts/Footer.vue";
import CustomButton from "@/components/CustomButton.vue";
import MdiEdit from "~icons/mdi/edit"
import MdiLock from "~icons/mdi/lock"
import ParticipantBanner from "@/components/ParticipantBanner.vue";
import {useUserStore} from "@/stores/useUserStore.ts";
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";
import ModalConfirm from "@/components/ModalConfirm.vue";
import {useCampaignStore} from "@/stores/useCampaignStore.ts";
import RecoveryForm from "@/components/RecoveryForm.vue";
import {useToast} from "primevue/usetoast";

// Définir une interface pour les méthodes exposées par ModalConfirm
interface ModalConfirmExpose {
  callConfirm: () => void
}

interface ModalRefs {
  [key: string]: ModalConfirmExpose | null
}

const toast = useToast()
const userStore = useUserStore()
const campaignStore = useCampaignStore()
const modalConfirmRefs = ref<ModalRefs>({})
const dialogRef = ref<{ show: () => void } | null>(null)

const showDialog = () => {
  if (dialogRef.value) {
    dialogRef.value.show()
  }
}
const confirmCloseCampaign = (campaignId: string | number) => {

  const id = String(campaignId)
  if (modalConfirmRefs.value[id]) {
    modalConfirmRefs.value[id]?.callConfirm()
  }
}

const closeCampaign = async (slug: string, id: string) => {
  const result = await campaignStore.closeCampaign(slug, id, {})

  if (!result.success) {
    toast.add({
      severity: 'error',
      summary: "Erreur",
      detail: result.message,
    })
    return
  }

  if (result.success) {
    await userStore.updateCampaignClosingDate(id)
    toast.add({
      severity: 'success',
      summary: "Succès",
      detail: "Votre cagnotte a été clôturée avec succès !"
    })
  }
}

onMounted(() => {
  userStore.getCampaignsOfUSer()
  userStore.getParticipantsOfUser()
})
</script>

<template>
  <Header/>
  <Main>
    <section class="container dashboard">
      <h1 class="dashboard-title">Votre Dashboard</h1>
      <div class="dashboard-list-campaigns">
        <article class="dashboard-campaign" v-for="campaign in userStore.campaignsUser" :key="campaign.id">
          <div class="dashboard-campaign-img">
            <img :src="campaign?.url_image" alt="image principale de la cagnotte"/>
          </div>
          <div class="dashboard-campaign-infos">
            <h2>{{ campaign.title }}</h2>
            <div class="dashboard-campaign-subinfos">
              <p>Collecté: {{ campaign.collected_amount / 100 }} €</p>
              <p>{{ campaign.participants?.length }}
                participant{{ campaign.participants?.length && campaign.participants?.length > 1 ? 's' : '' }}</p>
            </div>
            <div class="dashboard-campaign-list-btn" v-if="!campaign.closing_date">
              <RouterLink :to="{name: 'campaign.update', params: {slug: campaign.slug, id: campaign.id}}">
                <CustomButton label="modifier" :customComponent="MdiEdit"/>
              </RouterLink>
              <ModalConfirm
                  :ref="el => {if (el) modalConfirmRefs[campaign.id] = el as unknown as ModalConfirmExpose}"
                  :group="`closeCampaign-${campaign.id.toString()}`"
                  header="Clôture de la cagnotte"
                  message="Etes-vous sûr de vouloir clôturer cette cagnotte ? Cette action est irréversible"
                  :loading="campaignStore.loading"
                  :accept-fn="() => closeCampaign(campaign.slug, campaign.id as string)"
              >
                <CustomButton
                    label="clôturer"
                    :customComponent="MdiLock"
                    @click="() => confirmCloseCampaign(campaign.id)"
                />
              </ModalConfirm>
            </div>
            <div class="dashboard-campaign-btn-refund" v-else>
              <CustomButton
                  :customComponent="MdiEdit"
                  label="Faire un virement"
                  :disabled="campaign.recovery !== null"
                  @click="() => {
                    userStore.getDialogCampaign(campaign.id as number)
                    showDialog()
                  }"
              />
            </div>
          </div>
        </article>
      </div>
    </section>
    <section class="container participants">
      <h2 class="dashboard-second-title">Donateurs récents:</h2>
      <p v-if="userStore.participants?.length === 0">Il n'y a aucun participants pour les cagnottes actuelles</p>
      <ParticipantBanner :participants="userStore.participants" v-else/>
    </section>
  </Main>
  <Footer/>
  <RecoveryForm
      ref="dialogRef"
      :campaign="userStore.dialogCampaign"
  />
</template>

<style scoped>

.dashboard-list-campaigns {
  padding-inline: 10px;
}

.dashboard-list-campaigns article:not(:last-child) {
  margin-bottom: 1.8rem;
}


.dashboard-campaign {
  display: grid;
  grid-template-columns: repeat(2, minmax(200px, 1fr));
  grid-gap: 1rem;
  place-items: center stretch;
  height: 360px;
  padding: 0 1rem;
  border-radius: 10px;
  background-color: var(--secondary20);
}

.dashboard-title, .dashboard-second-title {
  text-align: center;
  margin-top: 1.5rem;
}

.dashboard-second-title {
  margin-bottom: 3.5rem;
}

.participants p {
  text-align: center;
}

.dashboard-campaign-img {
  height: 300px;
  border-radius: 10px;
}


.dashboard-campaign-img img {
  width: 100%;
  display: block;
  height: inherit;
  border-radius: 10px;
  aspect-ratio: 16 / 9;
  object-fit: cover;
}

.dashboard-campaign-infos {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2.8rem;
}

.dashboard-campaign-subinfos p {
  font-size: 1.175rem;
}


.dashboard-campaign-subinfos,
.dashboard-campaign-list-btn {
  width: 100%;
  display: flex;
  justify-content: space-around;
  gap: 1rem;
}

.dashboard-campaign-btn-refund {
  width: 100%;
}

.dashboard-campaign-btn-refund button {
  width: 100%;
  font-size: 1.125rem;
}

.dashboard-campaign-list-btn a button:first-child {
  width: 100%;
}


.dashboard-campaign-list-btn button:last-child,
.dashboard-campaign-list-btn a {
  width: 50%;
  font-size: 1.125rem;
}
</style>