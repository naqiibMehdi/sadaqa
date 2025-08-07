<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import Message from "primevue/message";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import Textarea from "primevue/textarea";
import {ref} from "vue";
import {useContactStore} from "@/stores/useContactStore.ts";
import {useToast} from "primevue/usetoast";

const formData = ref({email: "", description: ""})
const contactStore = useContactStore()
const toast = useToast()

const sendContact = async () => {
  await contactStore.sendContact({...formData.value})

  if (!contactStore.errors) {
    formData.value = {email: "", description: ""}
    toast.add({severity: 'success', summary: "Succès", detail: "Votre demande a bien été envoyée !", life: 5000});
  }
}

</script>

<template>
  <Header/>
  <Main>
    <h1>Assistance</h1>
    <p class="formContact-text">Si vous avez besoin d'aide, contactez-nous en utilisant le
      formulaire ci-dessous. Nous vous répondrons dans les plus brefs délais.
    </p>
    <form class="form-container" @submit.prevent="sendContact">
      <div class="form-inputLabel form-inputLabel_inline">
        <InputField placeholder="Email" id="email" title="Votre email :" size="large" v-model="formData.email"
                    :invalid="contactStore.errors?.email && contactStore.errors?.email[0] !== ''"/>
        <Message
            v-if="contactStore.errors?.email"
            severity="error"
            variant="simple"
            size="small"
        >
          {{ contactStore.errors?.email[0] }}
        </Message>
      </div>
      <div class="form-inputLabel form-inputLabel_inline">
        <label>Votre message :</label>
        <Textarea
            rows="7"
            cols="30"
            class="formContact-message"
            size="large"
            placeholder="Écrivez votre demande"
            v-model="formData.description"
            :invalid="contactStore.errors?.description && contactStore.errors?.description[0] !== ''"
        />
        <Message
            v-if="contactStore.errors?.description"
            severity="error"
            variant="simple"
            size="small"
        >
          {{ contactStore.errors?.description[0] }}
        </Message>
      </div>
      <CustomButton label="Envoyer votre message" type="submit" :loading="contactStore.loading"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formContact-text {
  margin-bottom: 2rem;
  max-width: 600px;
  text-align: center;
  line-height: 1.25rem;
  padding-inline: 10px;
}

.formContact-message:enabled:focus {
  border-color: var(--accent);
}

label {
  text-transform: capitalize;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>