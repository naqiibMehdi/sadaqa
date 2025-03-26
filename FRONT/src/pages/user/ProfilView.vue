<script setup lang="ts">

import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {useUserStore} from "@/stores/useUserStore.ts";
import {onMounted, ref} from "vue";
import {storeToRefs} from "pinia";
import Message from "primevue/message";

const userStore = useUserStore()
const {user, errorUpdateUserInfos} = storeToRefs(userStore)
const disabled = ref(true)
const image = ref<File | string>("")

onMounted(() => {
  userStore.getInfosUser()
})

const updateUserInfo = async () => {
  if (!disabled.value) {
    const body = {
      name: user.value.name,
      first_name: user.value.first_name,
      email: user.value.email,
      image: image.value
    }

    await userStore.updateInfosUser(body)

    if (errorUpdateUserInfos.value === null) {
      image.value = ""
      disabled.value = true
    }
    return
  }

  disabled.value = !disabled
}
</script>

<template>
  <section class="profil">
    <FileUploaderProfil :image-profile="user.image_profile" :disabled="disabled" v-model="image"/>
    <Message
        severity="error"
        variant="simple"
        size="small"
        v-if="errorUpdateUserInfos?.image"
        v-for="(errorMessage, idx) in errorUpdateUserInfos?.image"
        :key="idx"
    >
      {{ errorMessage }}
    </Message>
    <form class="form-container profil-form">
      <div class="form-inline">
        <div class="input-error">
          <InputField placeholder="Nom" id="nom" title="nom" v-model="user.name" :disabled="disabled"/>
          <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.name?.[0]">
            {{ errorUpdateUserInfos.name?.[0] }}
          </Message>
        </div>
        <div class="input-error">
          <InputField placeholder="Prénom" id="prenom" title="prénom" v-model="user.first_name" :disabled="disabled"/>
          <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.first_name?.[0]">
            {{ errorUpdateUserInfos.first_name?.[0] }}
          </Message>
        </div>
      </div>
      <InputField placeholder="example@gmail.com" id="email" title="Adresse email" v-model="user.email"
                  :disabled="disabled"/>
      <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.email?.[0]">
        {{ errorUpdateUserInfos.email?.[0] }}
      </Message>
      <p>Date de naissance:
        <strong>{{ (new Date(user.birth_date).toLocaleDateString()) }}</strong>
      </p>
      <CustomButton :label="disabled ? 'Modifier mon profil' : 'Enregistrer ma saisie'" @click="updateUserInfo"/>
      <CustomButton label="Annuler" :outline="true" v-if="!disabled  && !errorUpdateUserInfos"
                    @click="disabled = true"/>
    </form>
  </section>
</template>

<style scoped>

.profil {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.profil-form {
  width: 100%;
}

.profil-form .input-error {
  width: 50%;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>