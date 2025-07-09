<script setup lang="ts">
import {ref, onMounted} from 'vue';
import CustomButton from "@/components/CustomButton.vue";
import MdiFacebook from '~icons/mdi/facebook';
import MdiWhatsapp from '~icons/mdi/whatsapp';
import MdiTwitter from '~icons/mdi/twitter';
import MdiEmail from '~icons/mdi/email';
import MdiContentCopy from '~icons/mdi/content-copy';

type Props = {
  title: string,
  description: string,
}
// Props pour personnaliser le partage
const props = withDefaults(defineProps<Props>(), {
  title: 'Participez à ma cagnotte',
  description: 'Rejoignez-moi pour cette cagnotte et aidez-nous à atteindre notre objectif !'
});

const currentUrl = ref('');
const copied = ref(false);

onMounted(() => {
  // Récupérer l'URL actuelle
  currentUrl.value = window.location.href;
});

const copyToClipboard = () => {
  navigator.clipboard.writeText(currentUrl.value)
      .then(() => {
        copied.value = true;
        setTimeout(() => {
          copied.value = false;
        }, 2000);
      })
      .catch(err => {
        console.error('Erreur lors de la copie du lien:', err);
      });
};

const shareOnFacebook = () => {
  const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl.value)}`;
  window.open(url, '_blank', 'width=600,height=400');
};

const shareOnWhatsApp = () => {
  const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(props.title + ' ' + currentUrl.value)}`;
  window.open(url, '_blank');
};

const shareOnTwitter = () => {
  const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(props.title)}&url=${encodeURIComponent(currentUrl.value)}`;
  window.open(url, '_blank', 'width=600,height=300');
};

const shareByEmail = () => {
  const subject = encodeURIComponent(props.title);
  const body = encodeURIComponent(`${props.description}\n\n${currentUrl.value}`);
  window.location.href = `mailto:?subject=${subject}&body=${body}`;
};
</script>

<template>
  <div class="share-container">
    <div class="share-link-container">
      <input
          type="text"
          class="share-input"
          :value="currentUrl"
          readonly
          disabled
      />
      <button
          class="copy-button"
          @click="copyToClipboard"
          :class="{ 'copied': copied }"
      >
        <MdiContentCopy/>
        <span v-if="!copied">Copier</span>
        <span v-else>Copié !</span>
      </button>
    </div>

    <div class="share-buttons">
      <CustomButton
          label="Facebook"
          :custom-component="MdiFacebook"
          @click="shareOnFacebook"
          class="share-button facebook"
      />
      <CustomButton
          label="What's App"
          :custom-component="MdiWhatsapp"
          @click="shareOnWhatsApp"
          class="share-button whatsapp"
      />
      <CustomButton
          label="Twitter"
          :custom-component="MdiTwitter"
          @click="shareOnTwitter"
          class="share-button twitter"
      />
      <CustomButton
          label="Email"
          :custom-component="MdiEmail"
          @click="shareByEmail"
          class="share-button email"
      />
    </div>
  </div>
</template>

<style scoped>
.share-container {
  margin: 20px 0;
  padding: 15px;
  border-radius: 8px;
  background-color: #f8f9fa;
}

.share-link-container {
  display: flex;
  margin-bottom: 15px;
}

.share-input {
  flex-grow: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px 0 0 4px;
  background-color: #fff;
}

.copy-button {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 10px 15px;
  border: none;
  border-radius: 0 4px 4px 0;
  background-color: #4c82af;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s;
}

.copy-button:hover {
  background-color: #3a6a8f;
}

.copy-button.copied {
  background-color: #28a745;
}

.share-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.share-button {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 8px 12px;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  transition: opacity 0.3s;
}

:deep(.buttonFilled.share-button:hover) {
  opacity: 0.8;
  border: none;
  color: white;
  background-color: var(--primary);
}

.facebook {
  background-color: #3b5998;
}

.whatsapp {
  background-color: #25d366;
}

.twitter {
  background-color: #1da1f2;
}

.email {
  background-color: #747474;
}

@media (max-width: 600px) {
  .share-buttons {
    flex-direction: column;
  }
}
</style>
