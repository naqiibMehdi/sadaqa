<script setup lang="ts">
import Card from "primevue/card"
import {useRoute, RouterLink} from "vue-router";
import type {Campaign} from "@/types/types.ts";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {computed, onMounted, watch} from "vue";
import {titleAndMetaTag} from "@/utils/functions.ts";
import {useUserStore} from "@/stores/useUserStore.ts";
import {setMeta} from "@/utils/meta.ts";

const props = defineProps<{ campaign: Campaign }>()

const route = useRoute()
const authStore = useAuthStore()
const userStore = useUserStore()
const title = computed(() => props.campaign.title)
const description = computed(() => props.campaign.description)

const detailPage = computed(() => {
  return route.name === 'campaign' && route.params.slug && route.params.id
})

const isOwner = computed(() => userStore.user.id === props.campaign.user?.id)
const displayParticipantsOrAmount = (campaign: Campaign) => {
  if (route.name === 'campaigns') {
    return `avec <span style="font-weight: bold">${campaign.participants?.length}</span> participants`
  }

  return `récoltés sur <span style="font-weight: bold">${campaign.target_amount / 100}€</span>`
}

onMounted(() => {
  if (detailPage.value) {
    titleAndMetaTag(title.value.substring(0, 60), description.value.substring(0, 160))
    setMeta({
      title: props.campaign.title,
      description: props.campaign.description,
      image: props.campaign.url_image,
    })
  }
})

watch(() => props.campaign, (newCampaign) => {
  if (detailPage.value) {
    titleAndMetaTag(newCampaign.title.substring(0, 60), newCampaign.description.substring(0, 160))
    setMeta({
      title: newCampaign.title,
      description: newCampaign.description,
      image: newCampaign.url_image,
    })
  }
}, {deep: true})
</script>


<template>
  <RouterLink :to="{name: 'campaign', params: {slug: campaign.slug, id: campaign.id}}">
    <Card class="card-campaign">
      <template #header>
        <img :src="campaign.url_image" alt="image de la cagnotte">
        <div class="card-campaign-profil">
          <img :src="campaign.user?.image_profile"
               alt="photo de profil" class="card-campaign-profil-img">
          <div class="card-campaign-profil-infos">
            <p><span>{{ campaign.user?.public_name }}</span><br/> Lancée le {{
                (new Date(campaign.created_at)?.toLocaleDateString("fr-FR"))
              }}</p>
          </div>
        </div>
      </template>
      <template #title><h2 class="card-campaign-title">{{ campaign.title }}</h2></template>
      <template #content>
        <div class="card-campaign-content">
          <p class="card-campaign-content-price">{{ campaign.collected_amount / 100 }} €</p>
          <p class="card-campaign-content-participant" v-html="displayParticipantsOrAmount(campaign)"></p>
          <RouterLink :to="{name: 'payment'}" class="card-campaign-content-btn"
                      v-if="route.name !== 'campaigns' && campaign.closing_date === null">
            Participez
          </RouterLink>
          <RouterLink
              :to="{name: 'campaign.update', params: {slug: campaign.slug, id: campaign.id}}"
              class="card-campaign-content-btn"
              v-if="route.name !== 'campaigns' && authStore.token !== '' && isOwner && campaign.closing_date === null"
          >
            Modifier
          </RouterLink>
          <button
              class="card-campaign-content-btn_closed"
              disabled
              v-if="route.name !== 'campaigns' && campaign.closing_date !== null">Cagnotte clôturée
          </button>
        </div>
      </template>
    </Card>
  </RouterLink>
</template>

<style scoped>
.card-campaign {
  overflow: hidden;
  border-radius: unset;
}

.card-campaign:hover {
  cursor: pointer;
}

.card-campaign-profil {
  position: absolute;
  left: 10px;
  bottom: 10px;
  display: inline-flex;
  align-items: center;
  gap: 1rem;
}

.card-campaign-profil-img {
  width: 60px;
  height: 60px;
  border-radius: 50px;
  border: 3px solid var(--secondary);
}

.card-campaign-profil-infos {
  font-size: 0.8125rem;
  line-height: 19px;
}

.card-campaign-profil-infos p,
.card-campaign-profil-infos span {
  color: #ffffff;
  text-shadow: 0 1px 1px var(--text), 0 1px 4px var(--text);
}

.card-campaign-profil-infos span {
  font-size: 1rem;
}

.card-campaign-title {
  font-size: 1.125rem;
  text-align: center;
  text-transform: capitalize;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  font-weight: 900;
}

.card-campaign-title:first-letter {
  text-transform: uppercase;
}

.card-campaign-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .5rem;
}

.card-campaign-content-btn {
  width: 100%;
  font-size: 1.125rem;
  margin-top: 1rem;
  padding: 0.5em 2em;
  background-color: var(--accent);
  border-radius: .5rem;
  text-align: center;
}

.card-campaign-content-btn_closed {
  width: 100%;
  font-size: 1.125rem;
  margin-top: 1rem;
  padding: 0.5em 2em;
  background-color: lightgrey;
  border-radius: .5rem;
  border: transparent;
  text-align: center;
}

.card-campaign-content-btn_closed:hover {
  cursor: default;
}

.card-campaign-content-price {
  font-size: 1.75rem;
}
</style>