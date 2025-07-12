<script setup lang="ts">

import Nav from "@/components/layouts/Nav.vue";
import EntypoSocialTwitter from '~icons/entypo-social/twitter'
import EntypoSocialFacebook from '~icons/entypo-social/facebook'
import EntypoSocialInstagram from '~icons/entypo-social/instagram'
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
                     label: 'A propos de nous',
                     to: {name: 'about'}
                   }
                 ]"
        />
        <div class="footer-icons">
          <EntypoSocialFacebook class="footer-icons-fb"/>
          <EntypoSocialTwitter class="footer-icons-tw"/>
          <EntypoSocialInstagram class="footer-icons-inst"/>
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

.footer-icons-fb * {
  fill: #1877F2;

}

.footer-icons-tw * {
  fill: #1DA1F2;
}

.footer-icons-inst * {
  fill: #bc8a6a;
}
</style>