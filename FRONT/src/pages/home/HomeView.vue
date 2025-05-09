<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Footer from "@/components/layouts/Footer.vue";
import Main from "@/components/layouts/Main.vue";
import homeDonation from "@/assets/home-donation.svg"
import CustomButton from "@/components/CustomButton.vue";
</script>
<template>
  <Header/>
  <Main>
    <section class="home home-first container">
      <img :src="homeDonation" alt="Image illustrant des personnes faisant un don" class="home-image">
      <div style="display: flex; flex-direction: column; gap: 1.2rem">
        <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam amet cupiditate dicta doloribus explicabo facere illum libero non nulla odio praesentium quis quos rerum, similique temporibus totam voluptas voluptatem!</span><span>Ab aliquam blanditiis enim fuga veritatis. Ab alias architecto blanditiis dolor enim eveniet, ex, exercitationem inventore non odio odit quaerat quas sit sunt tenetur veniam, vitae. Asperiores est exercitationem minus?</span><span>Ab asperiores consequatur cumque distinctio dolore dolorem doloremque, esse eveniet ex incidunt ipsum officia quam quibusdam quisquam rerum similique temporibus. Accusantium, culpa delectus enim fuga quibusdam quo quos velit voluptatibus!</span>
        </p>
        <CustomButton label="Je finance une cagnotte"/>
      </div>
    </section>
  </Main>
  <Footer/>
</template>


<style scoped>
.home-first {
  display: grid;
  grid-template-columns: minmax(250px, 1fr) minmax(250px, 1fr);
  align-items: center;
  gap: 1.6rem;
}

</style>