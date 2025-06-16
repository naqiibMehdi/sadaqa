<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import Footer from "@/components/layouts/Footer.vue";
</script>

<template>
  <Header/>
  <Main>
    <div class="privacy-policy">
      <h1>Politique de Confidentialité</h1>
      <p><strong>Date d'entrée en vigueur : 16 juin 2025</strong></p>

      <section>
        <h2>1. Introduction</h2>
        <p>Bienvenue sur Saddaqa, un site de financement participatif. Nous nous engageons à protéger la
          confidentialité et la sécurité de vos informations personnelles. Cette politique de confidentialité explique
          comment nous collectons, utilisons, divulguons et protégeons vos informations personnelles.</p>
      </section>

      <section>
        <h2>2. Conformité au RGPD</h2>
        <p>Nous nous engageons à respecter les principes de protection des données énoncés dans le RGPD, qui incluent
          :</p>
        <ul>
          <li>La licéité, la loyauté et la transparence</li>
          <li>La limitation des finalités</li>
          <li>La minimisation des données</li>
          <li>L'exactitude</li>
          <li>La limitation de la conservation</li>
          <li>L'intégrité et la confidentialité</li>
          <li>La responsabilité</li>
        </ul>
        <p>Conformément au RGPD, nous traitons vos données personnelles de manière licite, loyale et transparente. Nous
          collectons vos données pour des finalités spécifiques, explicites et légitimes, et nous ne les traitons pas de
          manière incompatible avec ces finalités.</p>
      </section>

      <section>
        <h2>2. Informations Personnelles Collectées</h2>
        <p>Nous collectons les informations personnelles suivantes :</p>
        <ul>
          <li>Nom et prénom</li>
          <li>Adresse email</li>
          <li>Adresse postale</li>
          <li>IBAN (chiffré)</li>
          <li>Mot de passe (chiffré)</li>
        </ul>
      </section>

      <section>
        <h2>3. Utilisation des Informations Personnelles</h2>
        <p>Nous utilisons vos informations personnelles pour :</p>
        <ul>
          <li>Créer et gérer votre compte utilisateur</li>
          <li>Faciliter les transactions de financement participatif</li>
          <li>Communiquer avec vous concernant votre compte et nos services</li>
          <li>Améliorer nos services et personnaliser votre expérience sur notre site</li>
          <li>Se conformer à nos obligations légales et réglementaires</li>
        </ul>
      </section>

      <section>
        <h2>4. Protection des Informations Personnelles</h2>
        <p>Nous prenons des mesures de sécurité appropriées pour protéger vos informations personnelles contre la perte,
          le vol, l'accès non autorisé, la divulgation, la copie, l'utilisation ou la modification. Vos mots de passe et
          IBAN sont chiffrés pour assurer leur sécurité.</p>
      </section>

      <section>
        <h2>5. Partage des Informations Personnelles</h2>
        <p>Nous ne vendons ni ne louons vos informations personnelles à des tiers. Nous pouvons partager vos
          informations
          personnelles dans les cas suivants :</p>
        <ul>
          <li>Avec des prestataires de services qui nous aident à fournir nos services</li>
          <li>Pour se conformer à des obligations légales ou réglementaires</li>
          <li>Pour protéger et défendre nos droits et nos propriétés</li>
        </ul>
      </section>

      <section>
        <h2>6. Cookies</h2>
        <p>Nous utilisons des cookies pour améliorer votre expérience sur notre site. Vous pouvez accepter ou refuser
          les
          cookies via la bannière de consentement fournie par Axeptio. Vous pouvez modifier vos préférences en matière
          de
          cookies à tout moment.</p>
      </section>

      <section>
        <h2>7. Droits des Utilisateurs</h2>
        <p>Vous avez le droit de :</p>
        <ul>
          <li>Accéder à vos informations personnelles</li>
          <li>Modifier vos informations personnelles</li>
          <li>Supprimer définitivement votre compte et vos informations personnelles</li>
        </ul>
        <p>Pour exercer ces droits, veuillez vous connecter à votre compte ou nous contacter à [adresse email de
          contact].</p>
      </section>

      <section>
        <h2>8. Modifications de la Politique de Confidentialité</h2>
        <p>Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Les modifications
          entreront en vigueur dès leur publication sur notre site. Nous vous encourageons à consulter régulièrement
          cette
          politique pour rester informé de nos pratiques en matière de confidentialité.</p>
      </section>

      <section>
        <h2>9. Contact</h2>
        <p>Si vous avez des questions ou des préoccupations concernant cette politique de confidentialité, veuillez nous
          contacter à dpo@saddaqa.fr.</p>
      </section>
    </div>
  </Main>
  <Footer/>
</template>

<style scoped>
.privacy-policy {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  line-height: 1.6;
}

.privacy-policy h1 {
  text-align: center;
  color: #333;
}

.privacy-policy h2 {
  color: #444;
  margin-top: 20px;
}

.privacy-policy p {
  margin-bottom: 10px;
}

.privacy-policy ul {
  margin-bottom: 20px;
  padding-left: 20px;
}

.privacy-policy ul li {
  margin-bottom: 5px;
}
</style>
