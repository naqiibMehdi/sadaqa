import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import type {Campaign, Participant} from "@/types/types.ts";

interface propState {
    campaignsUser: Campaign[],
    participants: Participant[]
    error: string
}

export const useUserStore = defineStore("user", {
    state: (): propState => ({
        campaignsUser: [],
        participants: [],
        error: ""
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

    },
    getters: {}
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}