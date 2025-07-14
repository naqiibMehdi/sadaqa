<script setup lang="ts">

import Nav from "@/components/layouts/Nav.vue";
import EntypoSocialFacebookWithCircle from '~icons/entypo-social/facebook-with-circle';
import EntypoSocialTwitterWithCircle from '~icons/entypo-social/twitter-with-circle';
import EntypoSocialInstagramWithCircle from '~icons/entypo-social/instagram-with-circle';
</script>

<template>
  <footer class="footer">
    <div class="container">
      <p class="footer-text">Rejoignez notre communauté et soutenez des projets innovants qui transforment des idées en
        réalité. Ensemble, nous pouvons créer un impact positif et durable. Votre contribution, aussi petite soit-elle,
        fait une différence. Ensemble, nous pouvons inspirer le changement et construire un monde meilleur.
        Rejoignez-nous dès aujourd'hui et devenez un acteur du changement.</p>
      <div class="footer-nav">
        <Nav title="Saddaqa" :links="[{label: 'Accueil', to: {name: 'home'}}]"/>
        <Nav title="A Propos"
             :links="[
                   {
                     label: 'Contactez-nous',
                     to: {name: 'contact'}
                   },
                   {
                     label: 'Politique de confidentialité',
                     to: {name: 'privacy'}
                   },
                   {
                     label: 'RGPD',
                     to: {name: 'rgpd'}
                   },
                   {
                     label: 'A propos de nous',
                     to: {name: 'about'}
                   }
                 ]"
        />
        <div class="footer-icons">
          <EntypoSocialFacebookWithCircle class="footer-icons-fb"/>
          <a href="https://x.com/Saddaqa_assoc" target="_blank" rel="noreferrer">
            <EntypoSocialTwitterWithCircle class="footer-icons-tw"/>
          </a>
          <a href="https://www.instagram.com/assoc_sadaqa/">
            <EntypoSocialInstagramWithCircle class="footer-icons-inst"/>
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
footer {
  background-color: var(--text5);
  display: flex;
  justify-content: center;
  padding-inline: 10px;
  padding-block: 30px;
}

.footer-text {
  margin-bottom: 2rem;
  line-height: 1.4rem;
}

.footer-nav {
  display: flex;
  align-items: flex-start;
  justify-content: space-around;
}


.footer-icons {
  display: flex;
  gap: 0.75rem;
}

.footer-icons svg {
  width: 2rem;
  height: 2rem;
}

.footer-icons * {
  fill: var(--accent);
}
</style>