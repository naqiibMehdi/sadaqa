import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData, postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import type {Campaign, Participant, User} from "@/types/types.ts";

interface propState {
    campaignsUser: Campaign[],
    participants: Participant[],
    user: User,
    error: string
    errorUpdateUserInfos: { name?: string[], first_name?: string[], email?: string[], image?: string[] } | null,
    successMessage: string
}

export const useUserStore = defineStore("user", {
    state: (): propState => ({
        campaignsUser: [],
        participants: [],
        user: {name: "", first_name: "", email: "", image_profile: "", birth_date: new Date()},
        error: "",
        errorUpdateUserInfos: null,
        successMessage: ""
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

            try {
                const response = await postMultiPartData("user/profile/edit?_method=PUT", dataUser)
                this.user = response.data
                this.successMessage = response.message
                this.errorUpdateUserInfos = null
            } catch (err) {
                if (err instanceof AxiosError) {
                    this.errorUpdateUserInfos = err.response?.data.errors
                }
            }
        },

    },
    getters: {}
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}