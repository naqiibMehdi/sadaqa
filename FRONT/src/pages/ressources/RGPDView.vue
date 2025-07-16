<script setup lang="ts">
import {onMounted} from 'vue'
import Footer from "@/components/layouts/Footer.vue";

onMounted(() => {
  document.title = 'RGPD - Protection des données - Sadaqa'
})
</script>

<template>
  <div class="rgpd-page">
    <div class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title">RGPD</h1>
        <p class="hero-subtitle">Règlement Général sur la Protection des Données</p>
        <p class="hero-description">Vos données, vos droits, notre engagement</p>
      </div>
    </div>

    <main class="main">
      <div class="container">
        <section class="intro-section">
          <h2>Qu'est-ce que le RGPD ?</h2>
          <p class="intro-text">
            Le Règlement Général sur la Protection des Données (RGPD) est un texte réglementaire européen
            qui encadre le traitement des données personnelles sur le territoire de l'Union européenne.
            Entré en vigueur le 25 mai 2018, il renforce et unifie la protection des données pour les
            individus au sein de l'UE (https://www.cnil.fr/fr/reglement-europeen-protection-donnees).
          </p>
          <p class="intro-text">
            Chez Sadaqa, nous nous engageons à respecter scrupuleusement ce règlement pour assurer
            la protection de vos données personnelles et vous garantir une transparence totale sur
            leur utilisation.
          </p>
        </section>

        <section class="protection-section">
          <h2>Quelle protection vous apporte le RGPD ?</h2>
          <div class="protection-grid">
            <div class="protection-card">
              <div class="protection-icon">🛡️</div>
              <h3>Consentement explicite</h3>
              <p>Vous devez donner votre accord libre, spécifique et éclairé avant tout traitement de vos données
                (https://www.oasis-commerce.com/conseils-ecommerce/conformite-rgpd-principes-fondamentaux/).</p>
            </div>
            <div class="protection-card">
              <div class="protection-icon">🔒</div>
              <h3>Sécurité renforcée</h3>
              <p>Les organismes doivent mettre en place des mesures techniques et organisationnelles appropriées pour
                sécuriser vos données.</p>
            </div>
            <div class="protection-card">
              <div class="protection-icon">👁️</div>
              <h3>Transparence</h3>
              <p>Vous avez le droit de savoir quelles données sont collectées, pourquoi et comment elles sont
                utilisées.</p>
            </div>
            <div class="protection-card">
              <div class="protection-icon">⚖️</div>
              <h3>Responsabilité</h3>
              <p>Les entreprises sont tenues de démontrer leur conformité et peuvent être sanctionnées en cas de
                manquement.</p>
            </div>
          </div>
        </section>

        <section class="rights-section">
          <h2>Vos droits sur vos données</h2>
          <p class="rights-intro">
            Le RGPD vous confère plusieurs droits fondamentaux que vous pouvez exercer à tout moment
            (https://www.dastra.eu/fr/guide/droits-des-personnes-sur-leurs-donnees-personnelles/370) :
          </p>

          <div class="rights-list">
            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">📖</span>
                <h3>Droit d'accès</h3>
              </div>
              <p>Vous pouvez demander si vos données sont traitées et obtenir une copie de celles-ci, ainsi que des
                informations sur leur traitement.</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">✏️</span>
                <h3>Droit de rectification</h3>
              </div>
              <p>Vous avez le droit de faire corriger des données inexactes ou incomplètes vous concernant
                (https://www.cnil.fr/fr/mes-demarches/les-droits-pour-maitriser-vos-donnees-personnelles).</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">🗑️</span>
                <h3>Droit à l'effacement ("droit à l'oubli")</h3>
              </div>
              <p>Vous pouvez demander la suppression de vos données dans certaines circonstances, notamment si elles ne
                sont plus nécessaires.</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">⏸️</span>
                <h3>Droit à la limitation</h3>
              </div>
              <p>Vous pouvez demander la suspension temporaire du traitement de vos données dans certaines
                situations.</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">🚫</span>
                <h3>Droit d'opposition</h3>
              </div>
              <p>Vous pouvez vous opposer au traitement de vos données pour des motifs légitimes
                (https://www.cnil.fr/fr/passer-laction/les-droits-des-personnes-sur-leurs-donnees).</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">📦</span>
                <h3>Droit à la portabilité</h3>
              </div>
              <p>Vous pouvez récupérer vos données dans un format lisible et les transférer à un autre service
                (https://www.mission-rgpd.com/droit-portabilite-r/).</p>
            </div>

            <div class="right-item">
              <div class="right-header">
                <span class="right-icon">🤖</span>
                <h3>Droit relatif à la prise de décision automatisée</h3>
              </div>
              <p>Vous avez le droit de ne pas faire l'objet d'une décision fondée exclusivement sur un traitement
                automatisé.</p>
            </div>
          </div>
        </section>

        <section class="exercise-rights-section">
          <h2>Comment exercer vos droits ?</h2>
          <div class="exercise-steps">
            <div class="exercise-step">
              <div class="step-number">1</div>
              <div class="step-content">
                <h3>Contactez-nous</h3>
                <p>Envoyez votre demande par email à : <strong>rgpd@saddaqa.fr</strong></p>
              </div>
            </div>
            <div class="exercise-step">
              <div class="step-number">2</div>
              <div class="step-content">
                <h3>Précisez votre demande</h3>
                <p>Indiquez clairement quel droit vous souhaitez exercer et joignez une copie d'une pièce
                  d'identité.</p>
              </div>
            </div>
            <div class="exercise-step">
              <div class="step-number">3</div>
              <div class="step-content">
                <h3>Recevez notre réponse</h3>
                <p>Nous vous répondrons dans un délai d'un mois maximum à compter de la réception de votre demande.</p>
              </div>
            </div>
          </div>
        </section>

        <section class="sadaqa-commitment-section">
          <h2>L'engagement de Sadaqa</h2>
          <div class="commitment-content">
            <p>
              En tant qu'association à but non lucratif, Sadaqa s'engage à traiter vos données personnelles
              avec le plus grand soin et dans le strict respect du RGPD. Nous collectons uniquement les
              données nécessaires au fonctionnement de notre plateforme de dons et à l'amélioration de nos services.
            </p>
            <div class="commitment-points">
              <div class="commitment-point">
                <span class="commitment-icon">✅</span>
                <p>Collecte minimale de données</p>
              </div>
              <div class="commitment-point">
                <span class="commitment-icon">✅</span>
                <p>Sécurisation maximale</p>
              </div>
              <div class="commitment-point">
                <span class="commitment-icon">✅</span>
                <p>Transparence totale</p>
              </div>
              <div class="commitment-point">
                <span class="commitment-icon">✅</span>
                <p>Respect de vos droits</p>
              </div>
            </div>
          </div>
        </section>

        <section class="contact-section">
          <h2>Besoin d'aide ?</h2>
          <p>
            Si vous avez des questions concernant le traitement de vos données personnelles ou si vous
            souhaitez exercer vos droits, n'hésitez pas à nous contacter :
          </p>
          <div class="contact-info">
            <p><strong>Email :</strong> rgpd@saddaqa.fr</p>
            <p><strong>Délégué à la protection des données :</strong> dpo@saddaqa.fr</p>
          </div>
          <p class="cnil-info">
            En cas de litige, vous pouvez également saisir la Commission Nationale de l'Informatique
            et des Libertés (CNIL) : <a href="https://www.cnil.fr" target="_blank"
                                        rel="noopener noreferrer">www.cnil.fr</a>
          </p>
        </section>
      </div>
    </main>
  </div>
  <Footer/>
</template>

<style scoped>
.rgpd-page {
  min-height: 100vh;
  background-color: var(--background);
}

.hero-section {
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  color: var(--background);
  padding: 6rem 2rem 4rem;
  text-align: center;
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
}

.hero-title {
  font-size: 3rem;
  margin-bottom: 1rem;
  font-weight: 700;
}

.hero-subtitle {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  opacity: 0.9;
}

.hero-description {
  font-size: 1.125rem;
  opacity: 0.8;
}

.main {
  background: var(--background);
  border-radius: 2rem 2rem 0 0;
  margin-top: -2rem;
  position: relative;
}

.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}

section {
  padding: 4rem 0;
}

section:not(:last-child) {
  border-bottom: 1px solid var(--text5);
}

h2 {
  font-size: 2.5rem;
  color: var(--text);
  margin-bottom: 2rem;
  text-align: center;
  font-weight: 600;
}

.intro-text {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text);
  text-align: center;
  max-width: 900px;
  margin: 0 auto 2rem;
}

.protection-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.protection-card {
  background: var(--background);
  padding: 2.5rem 2rem;
  border-radius: 1rem;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid var(--secondary20);
  box-shadow: 0 4px 6px var(--text5);
}

.protection-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px var(--secondary20);
  border-color: var(--secondary);
}

.protection-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.protection-card h3 {
  font-size: 1.5rem;
  color: var(--text);
  margin-bottom: 1rem;
  font-weight: 600;
}

.protection-card p {
  color: var(--text50);
  line-height: 1.6;
}

.rights-intro {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text);
  text-align: center;
  max-width: 800px;
  margin: 0 auto 3rem;
}

.rights-list {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  max-width: 1000px;
  margin: 0 auto;
}

.right-item {
  background: var(--background);
  padding: 2rem;
  border-radius: 1rem;
  border: 1px solid var(--secondary20);
  box-shadow: 0 2px 4px var(--text5);
  transition: box-shadow 0.3s ease;
}

.right-item:hover {
  box-shadow: 0 4px 12px var(--secondary20);
}

.right-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.right-icon {
  font-size: 1.5rem;
}

.right-item h3 {
  font-size: 1.25rem;
  color: var(--text);
  font-weight: 600;
  margin: 0;
}

.right-item p {
  color: var(--text50);
  line-height: 1.6;
  margin: 0;
}

.exercise-steps {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  max-width: 800px;
  margin: 2rem auto 0;
}

.exercise-step {
  display: flex;
  align-items: flex-start;
  gap: 2rem;
  padding: 2rem;
  background: var(--background);
  border-radius: 1rem;
  border: 1px solid var(--secondary20);
  box-shadow: 0 2px 4px var(--text5);
}

.step-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--accent);
  color: var(--text);
  font-size: 1.25rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.step-content h3 {
  color: var(--text);
  margin-bottom: 0.5rem;
  font-size: 1.25rem;
}

.step-content p {
  color: var(--text50);
  line-height: 1.6;
  margin: 0;
}

.commitment-content {
  max-width: 800px;
  margin: 0 auto;
}

.commitment-content > p {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text);
  text-align: center;
  margin-bottom: 2rem;
}

.commitment-points {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}

.commitment-point {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: var(--background);
  border-radius: 0.5rem;
  border: 1px solid var(--secondary20);
}

.commitment-icon {
  font-size: 1.25rem;
  color: var(--accent);
}

.commitment-point p {
  color: var(--text);
  margin: 0;
  font-weight: 500;
}

.contact-section {
  text-align: center;
}

.contact-section > p {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text);
  max-width: 600px;
  margin: 0 auto 2rem;
}

.contact-info {
  background: var(--background);
  padding: 2rem;
  border-radius: 1rem;
  border: 1px solid var(--secondary20);
  max-width: 400px;
  margin: 0 auto 2rem;
}

.contact-info p {
  color: var(--text);
  margin: 0.5rem 0;
  font-size: 1.125rem;
}

.cnil-info {
  color: var(--text50);
  font-size: 0.9rem;
  margin-top: 2rem;
}

.cnil-info a {
  color: var(--primary);
  text-decoration: underline;
}

.cnil-info a:hover {
  color: var(--accent);
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
  }

  .hero-subtitle {
    font-size: 1.25rem;
  }

  h2 {
    font-size: 2rem;
  }

  .exercise-step {
    flex-direction: column;
    text-align: center;
  }

  .right-header {
    flex-direction: column;
    text-align: center;
    gap: 0.5rem;
  }

  .commitment-points {
    grid-template-columns: 1fr;
  }
}
</style>