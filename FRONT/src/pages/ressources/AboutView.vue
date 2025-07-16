<template>
  <div class="about-page">
    <div class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title">
          <span class="title-main">Sadaqa</span>
        </h1>
        <p class="hero-subtitle">La charité qui unit les cœurs</p>
      </div>
    </div>

    <main class="main">
      <div class="container">
        <section class="intro-section">
          <h2>Notre Mission</h2>
          <p class="intro-text">
            Sadaqa, qui signifie "charité" ou "aumône" en arabe, est une jeune association à but non lucratif
            dédiée à faciliter les dons et à créer des ponts entre les donateurs et les projets qui ont besoin
            de soutien. Notre mission est de rendre la générosité accessible à tous et de maximiser l'impact
            de chaque don.
          </p>
        </section>

        <section class="values-section">
          <h2>Nos Valeurs</h2>
          <div class="values-grid">
            <div class="value-card">
              <div class="value-icon">🤝</div>
              <h3>Solidarité</h3>
              <p>Nous croyons en la force de l'entraide et de la solidarité pour créer un monde meilleur.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">✨</div>
              <h3>Transparence</h3>
              <p>Chaque don est tracé avec transparence pour assurer la confiance de nos donateurs.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">🌍</div>
              <h3>Impact</h3>
              <p>Nous mesurons notre succès par l'impact positif créé dans la vie des bénéficiaires.</p>
            </div>
            <div class="value-card">
              <div class="value-icon">🚀</div>
              <h3>Innovation</h3>
              <p>Nous utilisons la technologie pour simplifier et moderniser les processus de don.</p>
            </div>
          </div>
        </section>

        <section class="how-it-works-section">
          <h2>Comment ça marche ?</h2>
          <div class="steps-container">
            <div class="step">
              <div class="step-number">1</div>
              <h3>Découvrez</h3>
              <p>Explorez les projets et associations partenaires qui ont besoin de votre soutien.</p>
            </div>
            <div class="step">
              <div class="step-number">2</div>
              <h3>Choisissez</h3>
              <p>Sélectionnez les causes qui vous tiennent à cœur et le montant que vous souhaitez donner.</p>
            </div>
            <div class="step">
              <div class="step-number">3</div>
              <h3>Donnez</h3>
              <p>Effectuez votre don en toute sécurité grâce à notre plateforme sécurisée.</p>
            </div>
            <div class="step">
              <div class="step-number">4</div>
              <h3>Suivez</h3>
              <p>Recevez des mises à jour sur l'utilisation de votre don et son impact.</p>
            </div>
          </div>
        </section>

        <section class="vision-section">
          <h2>Notre Vision</h2>
          <p>
            Nous rêvons d'un monde où chaque personne peut contribuer facilement à des causes qui lui tiennent à cœur.
            Sadaqa aspire à devenir la plateforme de référence pour connecter les donateurs avec les projets qui ont
            besoin de soutien, en créant une communauté engagée et bienveillante.
          </p>
        </section>

        <section class="join-section">
          <h2>Rejoignez-nous</h2>
          <p>
            Que vous soyez un donateur souhaitant faire une différence ou une organisation cherchant du soutien,
            Sadaqa est là pour vous accompagner. Ensemble, nous pouvons créer un impact positif durable.
          </p>
          <div class="cta-buttons">
            <RouterLink :to="{name: 'campaigns'}" class="btn btn-primary">Faire un don</RouterLink>
            <RouterLink :to="{name: 'contact'}" class="btn btn-secondary buttonOutlined">Nous contacter</RouterLink>
          </div>
        </section>
      </div>
    </main>
  </div>
  <Footer/>
</template>

<script setup lang="ts">

import Footer from "@/components/layouts/Footer.vue";
</script>

<style scoped>
.about-page {
  min-height: 100vh;
  background-color: var(--background);
}

.hero-section {
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  color: var(--background);
  padding: 8rem 2rem 4rem;
  text-align: center;
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
}

.hero-title {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  font-weight: 700;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
}

.title-main {
  font-size: 3.5rem;
  font-weight: 700;
}

.hero-subtitle {
  font-size: 1.25rem;
  opacity: 0.9;
  margin-top: 1rem;
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
  max-width: 800px;
  margin: 0 auto;
}

.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.value-card {
  background: var(--background);
  padding: 2.5rem 2rem;
  border-radius: 1rem;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid var(--secondary20);
  box-shadow: 0 4px 6px var(--text5);
}

.value-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px var(--secondary20);
  border-color: var(--secondary);
}

.value-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.value-card h3 {
  font-size: 1.5rem;
  color: var(--text);
  margin-bottom: 1rem;
  font-weight: 600;
}

.value-card p {
  color: var(--text50);
  line-height: 1.6;
}

.steps-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.step {
  text-align: center;
  padding: 2rem;
}

.step-number {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  color: var(--background);
  font-size: 1.5rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
}

.step h3 {
  font-size: 1.25rem;
  color: var(--text);
  margin-bottom: 1rem;
  font-weight: 600;
}

.step p {
  color: var(--text50);
  line-height: 1.6;
}

.vision-section p,
.join-section p {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text);
  text-align: center;
  max-width: 800px;
  margin: 0 auto;
}

.cta-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

.btn {
  padding: 1rem 2rem;
  border: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-block;
}

.btn-primary {
  background-color: var(--accent);
  color: var(--text);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 20px var(--secondary20);
}

.btn-secondary {
  background: transparent;
  color: var(--text);
  border: 2px solid var(--primary);
}

.btn-secondary:hover {
  background-color: var(--background-90);
  color: var(--text);
}

</style>