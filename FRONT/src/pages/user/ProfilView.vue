<script setup lang="ts">

import FileUploaderProfil from "@/components/FileUploaderProfil.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue";
import {useUserStore} from "@/stores/useUserStore.ts";
import {onMounted, ref, watch} from "vue";
import {storeToRefs} from "pinia";
import Message from "primevue/message";
import {User} from "@/types/types.ts";
import Divider from "primevue/divider";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {useRouter} from "vue-router";
import {useToast} from "primevue/usetoast";
import ModalConfirm from "@/components/ModalConfirm.vue";

const userStore = useUserStore()
const {user, errorUpdateUserInfos} = storeToRefs(userStore)
const disabled = ref(true)
const image = ref<File | string>("")
const formUserData = ref<User>(user.value)
const passwordData = ref({password: "", password_confirmation: ""})
const authStore = useAuthStore()
const router = useRouter()
const toast = useToast()
const modalConfirmDelete = ref<typeof ModalConfirm | null>(null)

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

const deleteAccount = async () => {
  await userStore.deleteAccountUser()
  authStore.token = ""
  await router.push({name: "login"})
  toast.add({severity: 'success', summary: "Message de succès", detail: userStore.successMessage, life: 5000});
}

const confirmDeleteAccount = () => {
  if (modalConfirmDelete.value) {
    modalConfirmDelete.value.callConfirm()
  }
}

const updatePassword = async () => {
  await userStore.updatePasswordUser(passwordData.value)

  if (!userStore.errorPassword) {
    passwordData.value = {password: "", password_confirmation: ""}
    toast.add({severity: 'success', summary: "Message de succès", detail: userStore.successMessage, life: 5000})
  }
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
      <p>
        Date de naissance: <strong>{{ (new Date(user.birth_date).toLocaleDateString()) }}</strong>
      </p>
      <CustomButton :loading="userStore.loading" :label="disabled ? 'Modifier mon profil' : 'Enregistrer ma saisie'"
                    @click="updateUserInfo"/>
      <CustomButton label="Annuler" :outline="true" v-if="!disabled"
                    @click="cancelFormData" :disabled="userStore.loading"/>
    </form>

    <Divider/>

    <!-- formulaire pour modifier le mot de passe  -->
    <h2>Modifier mon mot de passe</h2>
    <form class="form-container profil-password" @submit.prevent="updatePassword">
      <InputField
          placeholder="Mot de passe"
          id="password"
          title="Mot de passe"
          type="password"
          :invalid="userStore.errorPassword && userStore.errorPassword?.length > 0"
          v-model="passwordData.password"
      />
      <InputField
          placeholder="Confirmer votre mot de passe"
          id="password_confirmation"
          title="Confirmez votre mot de passe"
          type="password"
          :invalid="userStore.errorPassword && userStore.errorPassword?.length > 0"
          v-model="passwordData.password_confirmation"
      />
      <Message
          severity="error"
          variant="simple"
          size="small"
          v-if="userStore.errorPassword"
          v-for="error in userStore.errorPassword"
      >
        {{ error }}
      </Message>
      <div class="formConnexion-buttons-list">
        <CustomButton label="Modifier mon mot de passe" type="submit" :loading="userStore.loadingPassword"/>
      </div>
    </form>

    <Divider/>

    <div class="profil-delete-account">
      <h2 class="profil-delete-account-title">Mon compte</h2>
      <p>Si vous supprimez votre compte, cela mènera à la perte de toutes vos informations (données personnelles,
        cagnottes et don des participants)</p>
      <ModalConfirm ref="modalConfirmDelete" group="delete" :acceptFn="deleteAccount">
        <CustomButton label="Supprimer mon compte" @click="confirmDeleteAccount" class="profil-delete-account-button"/>
      </ModalConfirm>
    </div>
  </section>
</template>

<style scoped>

.profil, .profil-delete-account {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.profil-form, .profil-password {
  width: 100%;
  max-width: none;
  padding-inline: 10px;
}

.profil-form .input-error {
  width: 50%;
}

.profil-delete-account {
  padding-inline: 10px;
}

.profil-delete-account-button {
  background-color: red;
  color: white;
}

.profil-delete-account .profil-delete-account-button:hover {
  background-color: darkred;
  color: white;
}

.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}

</style>