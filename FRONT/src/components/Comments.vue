<script setup lang="ts">
import Carousel from 'primevue/carousel';
import {ref} from "vue";

const data = ref([
  {
    username: 'Charlotte',
    imageProfile: 'https://randomuser.me/api/portraits/women/70.jpg',
    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam amet autem beatae blanditiis cupiditate delectus dignissimos doloribus earum exercitationem id ipsum maiores nemo officiis recusandae saepe ullam veniam, voluptas?"
  },
  {
    username: 'Kingston',
    imageProfile: 'https://randomuser.me/api/portraits/men/70.jpg',
    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam amet autem beatae blanditiis cupiditate delectus dignissimos doloribus earum exercitationem id ipsum maiores nemo officiis recusandae saepe ullam veniam, voluptas?"
  },
  {
    username: 'Peter',
    imageProfile: 'https://randomuser.me/api/portraits/men/10.jpg',
    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam amet autem beatae blanditiis cupiditate delectus dignissimos doloribus earum exercitationem id ipsum maiores nemo officiis recusandae saepe ullam veniam, voluptas?"
  }
])
</script>

<template>
  <Carousel :value="data" :numVisible="1" :numScroll="1">
    <template #item="slotProps">
      <div class="comments-section">
        <div class="comment">
          <div class="comment-avatar">
            <img :src="slotProps.data.imageProfile" alt="Photo de profil">
          </div>
          <div class="comment-content">
            <div class="comment-header">
              <span class="comment-author">{{ slotProps.data.username }}</span>
            </div>
            <p class="comment-text"><span>{{ slotProps.data.comment }}</span>
            </p>
          </div>
        </div>
      </div>
    </template>
  </Carousel>
</template>

<style scoped>
.comments-section {
  width: 100%;
  max-width: 800px;
  margin: 2rem auto;
}

.comment {
  display: flex;
  gap: 1rem;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  background-color: var(--background);
  border-radius: 0.5rem;
  box-shadow: 0 2px 4px var(--text5);
}

.comment-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
}

.comment-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.comment-content {
  flex-grow: 1;
}

.comment-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.comment-author {
  font-weight: bold;
  color: var(--text);
}

.comment-text {
  color: var(--text);
  line-height: 1.5;
}

</style>