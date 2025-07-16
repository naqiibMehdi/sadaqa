<script setup lang="ts">

import Header from "@/components/layouts/Header.vue";
import Main from "@/components/layouts/Main.vue";
import InputField from "@/components/InputField.vue";
import CustomButton from "@/components/CustomButton.vue"
import Footer from "@/components/layouts/Footer.vue";
import Select from "primevue/select"
import Message from 'primevue/message'
import {ref, onMounted} from "vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {storeToRefs} from "pinia";
import {useRouter} from "vue-router";

const day = ref<string | number>(0)
const month = ref<string | number>(0)
const year = ref<string | number>(0)
const router = useRouter()

const daysOptions = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31])
const monthsOptions = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
const yearsOptions = ref<number[]>([])

const userData = ref({
  name: "",
  first_name: "",
  public_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  birth_date: ""
})

// gestion du store "Auth"
const authStore = useAuthStore()
const {errors} = storeToRefs(authStore)

const generateYears = () => {
  let years = []
  for (let year = 1950; year <= (new Date()).getFullYear() - 18; year++) {
    years.push(year)
  }

  return years.reverse()
}

const formatedDate = () => {
  return `${year.value}-${month.value}-${day.value}`
}

const resetForm = () => {
  userData.value = {
    name: "",
    first_name: "",
    public_name: "",
    email: "",
    password: "",
    password_confirmation: "",
    birth_date: ""
  }

  day.value = 0
  month.value = 0
  year.value = 0
}

const submitForm = async () => {
  await authStore.createUser({...userData.value, birth_date: formatedDate()})

  if (authStore.errors === null) {
    resetForm()
    await router.push({name: "login"})
  }
}

onMounted(() => yearsOptions.value = generateYears())


</script>

<template>
  <Header/>
  <Main>
    <h1>Formulaire d'inscription</h1>
    <form class="form-container" @submit.prevent="submitForm">
      <div class="form-inline">
        <div class="formRegister-input-error">
          <InputField placeholder="Nom" id="nom" title="nom" v-model="userData.name"
                      :invalid="errors?.name && errors?.name?.[0] !== '' "/>
          <Message severity="error" variant="simple" size="small" v-if="errors?.name?.[0]">{{
              errors?.name?.[0]
            }}
          </Message>
        </div>
        <div class="formRegister-input-error">
          <InputField placeholder="Prénom" id="prenom" title="prénom" v-model="userData.first_name"
                      :invalid="errors?.first_name && errors.first_name?.[0] !== '' "/>
          <Message severity="error" variant="simple" size="small" v-if="errors?.first_name?.[0]">{{
              errors?.first_name?.[0]
            }}
          </Message>
        </div>
      </div>
      <InputField placeholder="Ex: Toto" id="publicname" title="nom Public" v-model="userData.public_name"
                  :invalid="errors?.public_name && errors.public_name?.[0] !== '' "/>
      <Message severity="error" variant="simple" size="small" v-if="errors?.public_name?.[0]">{{
          errors?.public_name?.[0]
        }}
      </Message>
      <InputField placeholder="Email" id="email" title="email" v-model="userData.email"
                  :invalid="errors?.email && errors.email?.[0] !== '' "/>
      <Message severity="error" variant="simple" size="small" v-if="errors?.email?.[0]">{{
          errors?.email?.[0]
        }}
      </Message>
      <InputField
          placeholder="Mot de passe"
          id="password"
          title="mot de passe"
          v-model="userData.password"
          type="password"
          :invalid="errors?.password && errors?.password?.[0] !== '' "
      />
      <Message severity="error" variant="simple" size="small" v-if="errors?.password?.[0]">{{
          errors?.password?.[0]
        }}
      </Message>
      <InputField
          placeholder="Mot de passe"
          id="confirmation_password"
          title="Confirmez votre mot de passe"
          type="password"
          v-model="userData.password_confirmation"
          :invalid="errors?.password && errors?.password?.[0] !== '' "
      />
      <Message severity="error" variant="simple" size="small" v-if="errors?.password?.[0]">{{
          errors?.password?.[0]
        }}
      </Message>
      <div class="formRegister-date">
        <p class="formRegister-title">Vous devez être majeur</p>
        <div class="formRegister-select">
          <Select v-model="day" placeholder="Jour" :options="daysOptions"
                  :invalid="errors?.birth_date && errors?.birth_date?.[0] !== '' "/>
          <Select v-model="month" placeholder="Mois" :options="monthsOptions"
                  :invalid="errors?.birth_date && errors?.birth_date?.[0] !== '' "/>
          <Select v-model="year" placeholder="Année" :options="yearsOptions"
                  :invalid="errors?.birth_date && errors?.birth_date?.[0] !== '' "/>
        </div>
        <Message severity="error" variant="simple" size="small" v-if="errors?.birth_date?.[0]">{{
            errors?.birth_date?.[0]
          }}
        </Message>
      </div>
      <CustomButton label="Créer votre compte" type="submit" :loading="authStore.loading"/>
    </form>
  </Main>
  <Footer/>
</template>

<style scoped>

.formRegister-title {
  margin-bottom: 0.9rem;
}

.formRegister-select {
  width: 100%;
  display: inline-flex;
  gap: 1.3rem;
  margin-bottom: 1rem;
}

.formRegister-input-error {
  width: 50%;
  display: flex;
  flex-direction: column;
  gap: .7rem;
}

.p-select {
  width: calc(100% / 3);
}


.buttonFilled {
  width: 100%;
  margin-top: 1.3rem;
  font-size: 1.125rem;
}
</style>