<script setup lang="ts">

import Header from "@/components/Header.vue";
import Main from "@/components/Main.vue";
import Footer from "@/components/Footer.vue";
import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
</script>

<template>
  <Header/>
  <Main>
    <h1>Votre Profil</h1>
    <section class="profil">
      <aside class="profil-image">
        <FileUploaderProfil/>
      </aside>
      <form class="form-container profil-form">
        <div class="form-inline">
          <InputField placeholder="Nom" id="nom" title="nom"/>
          <InputField placeholder="Prénom" id="prenom" title="prénom"/>
        </div>
        <div class="form-inline">
          <InputField placeholder="Paris" id="borntown" title="Ville de naissance"/>
          <InputField placeholder="France" id="borncountry" title="Pays de naissance"/>
        </div>
        <InputField placeholder="France" id="nationality" title="Nationalité"/>
        <div class="form-inline">
          <InputField placeholder="Nom" id="nom" title="Adresse"/>
          <InputField placeholder="Prénom" id="prenom" title="Code postale"/>
        </div>
        <div class="form-inline">
          <InputField placeholder="Paris" id="borntown" title="Ville"/>
          <InputField placeholder="France" id="borncountry" title="Pays"/>
        </div>
        <InputField placeholder="France" id="borncountry" title="Numéro de téléphone"/>
      </form>
    </section>
  </Main>
  <Footer/>
</template>

<style scoped>
.profil {
  width: calc(100% / 2);
  max-width: 1140px;
  display: grid;
  grid-template-columns: 200px 1fr;
  column-gap: 1.3rem;
}


.profil-form {
  width: 100%;
}

</style>