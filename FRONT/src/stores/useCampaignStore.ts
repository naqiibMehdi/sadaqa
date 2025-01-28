import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData} from "@/utils/axios.ts";
import type {Campaign} from "@/types/types.ts";

export const useCampaignStore = defineStore("campaign", {
    state: (): {
        campaigns: { data?: Campaign[], links?: {}, meta?: {} },
        loading: boolean,
        error: boolean | null
    } => ({
        campaigns: {},
        loading: false,
        error: null
    }),
    actions: {
        async getCampaigns() {
            this.loading = true
            try {
                this.campaigns = await fetchData("/campaigns")
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false
            }
        }
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useCampaignStore, import.meta.hot))
}