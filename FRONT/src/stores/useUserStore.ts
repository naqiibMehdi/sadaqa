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
            this.participants = []
            
            try {
                const response = await fetchData("user/dashboard");
                this.campaignsUser = response.data
            } catch (err) {
                if (err instanceof AxiosError) {
                    this.error = "Erreur de chargement des cagnottes"
                }
            }
        },

    },
    getters: {
        getAllParticipantsOfUser() {
            this.campaignsUser.forEach(campaign => {
                if (campaign.participants) {
                    for (let p of campaign.participants) {
                        this.participants.push({title: campaign.title, ...p})
                    }
                }
            })
        }
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}