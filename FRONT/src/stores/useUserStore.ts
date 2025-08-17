import {acceptHMRUpdate, defineStore} from "pinia";
import {deleteData, fetchData, postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import type {Campaign, Participant, User} from "@/types/types.ts";

interface propState {
  campaignsUser: Campaign[],
  participants: Participant[],
  dialogCampaign: { id: string | number, title: string, collected_amount: number } | null,
  user: User,
  error: string
  errorUpdateUserInfos: { name?: string[], first_name?: string[], email?: string[], image?: string[] } | null,
  errorPassword: string[] | null,
  successMessage: string,
  loading: boolean,
  loadingPassword: boolean,
  loadingProfileUser: boolean,
}

export const useUserStore = defineStore("user", {
  state: (): propState => ({
    campaignsUser: [],
    participants: [],
    dialogCampaign: null,
    user: {name: "", first_name: "", email: "", image_profile: "", birth_date: new Date()},
    errorPassword: null,
    error: "",
    errorUpdateUserInfos: null,
    successMessage: "",
    loading: false,
    loadingPassword: false,
    loadingProfileUser: false
  }),
  actions: {
    async getCampaignsOfUSer() {
      this.error = ""
      this.loading = true
      this.campaignsUser = []

      try {
        const response = await fetchData("user/dashboard");
        this.campaignsUser = response.data
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des cagnottes"
        }
      } finally {
        this.loading = false
      }
    },
    async getInfosUser() {
      this.error = ""
      this.loading = true
      try {
        const response = await fetchData("user/profile")
        this.user = response.data
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = "Erreur de chargement des données de l'utilisateur"
        }
      } finally {
        this.loading = false
      }
    },

    async initialiseUser() {
      const token = localStorage.getItem("token")
      if (token) {
        await this.getInfosUser()
      }
    },

    async updateInfosUser(dataUser: {
      name: string,
      first_name: string,
      email: string,
      image: File | string
    }) {
      this.error = ""
      this.loadingProfileUser = true

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
        this.loadingProfileUser = false
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

    async updateCampaignClosingDate(campaignId: string | number) {
      const id = campaignId.toString()
      const campaignIndex = this.campaignsUser.findIndex(campaign => campaign.id.toString() === id)

      if (campaignIndex !== -1) {
        this.campaignsUser[campaignIndex].closing_date = new Date().toISOString()
      }
    },

    async updateRecoveryCampaign(campaignId: string | number) {
      const id = campaignId.toString()
      const campaignIndex = this.campaignsUser.findIndex(campaign => campaign.id.toString() === id)

      if (campaignIndex !== -1) {
        this.campaignsUser[campaignIndex].recovery = {
          total_amount: 0,
          campaign_id: 0,
          created_at: "",
          id: 0,
          status: "pending",
          user_id: 0,
        }
      }
    }


  },
  getters: {
    getDialogCampaign(state) {
      return (idCampaign: number): void => {
        const campaign = state.campaignsUser.find(campaign => campaign.id === idCampaign)
        if (campaign) {
          const {id, title, collected_amount} = campaign
          state.dialogCampaign = {id, title, collected_amount}

        } else {
          state.dialogCampaign = null
        }
      }
    }
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}