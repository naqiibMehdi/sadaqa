<script setup lang="ts">

import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {useUserStore} from "@/stores/useUserStore.ts";
import {onMounted, ref, watch} from "vue";
import {storeToRefs} from "pinia";
import Message from "primevue/message";
import {User} from "@/types/types.ts";

const userStore = useUserStore()
const {user, errorUpdateUserInfos} = storeToRefs(userStore)
const disabled = ref(true)
const image = ref<File | string>("")
const formUserData = ref<User>(user.value)

onMounted(() => {
  userStore.getInfosUser()
})

watch(() => user.value, (newUser) => {
  if (newUser) {
    formUserData.value = newUser
  }
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
      formUserData.value = user.value
    }
    return
  }

  disabled.value = !disabled
}

const cancelFormData = () => {
  formUserData.value = user.value
  image.value = ""
  errorUpdateUserInfos.value = null
  disabled.value = true
}
</script>

<template>
  <section class="profil">
    <FileUploaderProfil :image-profile="formUserData.image_profile" :disabled="disabled" v-model="image"/>
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
          <InputField placeholder="Nom" id="nom" title="nom" v-model="formUserData.name" :disabled="disabled"/>
          <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.name?.[0]">
            {{ errorUpdateUserInfos.name?.[0] }}
          </Message>
        </div>
        <div class="input-error">
          <InputField placeholder="Prénom" id="prenom" title="prénom" v-model="formUserData.first_name"
                      :disabled="disabled"/>
          <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.first_name?.[0]">
            {{ errorUpdateUserInfos.first_name?.[0] }}
          </Message>
        </div>
      </div>
      <InputField placeholder="example@gmail.com" id="email" title="Adresse email" v-model="formUserData.email"
                  :disabled="disabled"/>
      <Message severity="error" variant="simple" size="small" v-if="errorUpdateUserInfos?.email?.[0]">
        {{ errorUpdateUserInfos.email?.[0] }}
      </Message>
      <p>Date de naissance:
        <strong>{{ (new Date(user.birth_date).toLocaleDateString()) }}</strong>
      </p>
      <CustomButton :loading="userStore.loading" :label="disabled ? 'Modifier mon profil' : 'Enregistrer ma saisie'"
                    @click="updateUserInfo"/>
      <CustomButton label="Annuler" :outline="true" v-if="!disabled"
                    @click="cancelFormData" :disabled="userStore.loading"/>
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