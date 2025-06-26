import {acceptHMRUpdate, defineStore} from "pinia";
import {deleteData, fetchData, postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import type {Campaign, Participant, User} from "@/types/types.ts";

interface propState {
  campaignsUser: Campaign[],
  participants: Participant[],
  user: User,
  error: string
  errorUpdateUserInfos: { name?: string[], first_name?: string[], email?: string[], image?: string[] } | null,
  errorPassword: string[] | null,
  successMessage: string,
  loading: boolean,
  loadingPassword: boolean,
}

export const useUserStore = defineStore("user", {
  state: (): propState => ({
    campaignsUser: [],
    participants: [],
    user: {name: "", first_name: "", email: "", image_profile: "", birth_date: new Date()},
    errorPassword: null,
    error: "",
    errorUpdateUserInfos: null,
    successMessage: "",
    loading: false,
    loadingPassword: false,
  }),
  actions: {
    async getCampaignsOfUSer() {
      this.error = ""
      this.campaignsUser = []

      try {
        const response = await fetchData("user/dashboard");
        this.campaignsUser = response.data
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des cagnottes"
        }
      }
    },
    async getParticipantsOfUser() {
      this.error = ""
      this.participants = []

      try {
        this.participants = await fetchData("user/participants")
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des participants"
        }
      }
    },

    async getInfosUser() {
      this.error = ""

      try {
        const response = await fetchData("user/profile")
        this.user = response.data
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des données de l'utilisateur"
        }
      }
    },

    async updateInfosUser(dataUser: {
      name: string,
      first_name: string,
      email: string,
      image: File | string
    }) {
      this.error = ""
      this.loading = true

      try {
        const response = await postMultiPartData("user/profile/edit?_method=PUT", dataUser)
        this.user = response.data
        this.successMessage = response.message
        this.errorUpdateUserInfos = null
      } catch (err) {
        if (err instanceof AxiosError) {
          this.errorUpdateUserInfos = err.response?.data.errors
        }
      } finally {
        this.loading = false
      }
    },
    async updatePasswordUser(dataUser: {
      password: string,
      password_confirmation: string,
    }) {
      this.successMessage = ""
      this.errorPassword = null
      this.loadingPassword = true

      try {
        const response = await postMultiPartData("user/profile/edit/password?_method=PUT", dataUser)
        this.successMessage = response.message
      } catch (err) {
        if (err instanceof AxiosError) {
          this.errorPassword = err.response?.data.errors.password
        }
      } finally {
        this.loadingPassword = false
      }
    },

    async deleteAccountUser() {
      this.error = ""
      this.loading = true
      try {
        const response = await deleteData("user/profile", {})
        this.successMessage = response.message
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de suppression du compte utilisateur"
        }
      } finally {
        this.loading = false
      }
    },

  },
  getters: {}
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}