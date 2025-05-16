<script setup lang="ts">
import {computed} from "vue";

type Props = {
  campaign: { title: string, target_amount: number, collected_amount: number, url_image: string }
}

const props = defineProps<Props>()

const amountFormatted = (key: "target_amount" | "collected_amount") => computed(() => {
  return new Intl.NumberFormat("fr-FR", {
    style: "currency",
    currency: "EUR",
    minimumFractionDigits: 0
  }).format(props.campaign[key])
})

</script>


<template>
  <article class="cardCampaignHome">
    <p class="cardCampaignHome_title">{{ campaign.title }}</p>
    <div class="cardCampaignHome_body">
      <div class="cardCampaignHome_body_image" :style="{backgroundImage: `url(${campaign.url_image})`}" role="img"
           aria-label="image principale de la cagnotte"></div>
      <div class="cardCampaignHome_body_content">
        <p class="cardCampaignHome_body_content_price">{{ amountFormatted("collected_amount") }}</p>
        <p class="cardCampaignHome_body_total_price">récoltés sur <span>{{ amountFormatted("target_amount") }}</span>
        </p>
      </div>
    </div>
  </article>
</template>

<style scoped>
.cardCampaignHome {
  overflow: hidden;
  border-radius: unset;
  display: flex;
  flex-direction: column;
  gap: 1.4rem;
}

.cardCampaignHome_title {
  font-size: 1.125rem;
  text-align: center;
  text-transform: capitalize;
  overflow: hidden;
  text-overflow: ellipsis;
  font-weight: 900;
  height: 50px;
}

.cardCampaignHome_title:first-letter {
  text-transform: uppercase;
}

.cardCampaignHome_body {
  min-height: 230px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  border-radius: 6px;
  border: solid 1px var(--text5);
}

.cardCampaignHome_body_image {
  height: 148px;
  width: 100%;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.cardCampaignHome_body_content {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-block: 14px;
}


.cardCampaignHome_body_content_price {
  font-size: 1.75rem;
  font-weight: 600;
}


.cardCampaignHome_body_total_price span {
  font-weight: 600;
}
</style>