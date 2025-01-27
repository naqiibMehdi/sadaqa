<script setup lang="ts">

import Nav from "@/components/layouts/Nav.vue";
import {Divider} from "primevue";
import EntypoSocialTwitter from '~icons/entypo-social/twitter'
import EntypoSocialFacebook from '~icons/entypo-social/facebook'
import EntypoSocialInstagram from '~icons/entypo-social/instagram'
</script>

<template>
  <footer class="footer">
    <div class="container">
      <p class="footer-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
        ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat.
      </p>
      <div class="footer-nav">
        <Nav title="Ressource" :links="['ressource 1', 'ressource 2']"/>
        <Nav title="A Propos" :links="['ressource 1', 'ressource 2']"/>
        <Divider type="solid" layout="vertical" class="dv"/>
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
  padding: 1.8rem 0;
}

.footer-text {
  margin-bottom: 2rem
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