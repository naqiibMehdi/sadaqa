import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData, postMultiPartData} from "@/utils/axios.ts";
import type {Campaign, errorFormCampaign} from "@/types/types.ts";
import {AxiosError} from "axios";

export const useCampaignStore = defineStore("campaign", {
    state: (): {
        campaigns: { data: Campaign[], links: {}, meta: {} },
        campaign: Campaign | null,
        totalItems: number,
        itemsPerPage: number,
        currentPage: number | string,
        loading: boolean,
        error: string | null,
        errorsFormCampaign: errorFormCampaign | null,
    } => ({
        campaigns: {data: [], links: {}, meta: {}},
        campaign: null,
        totalItems: 0,
        itemsPerPage: 9,
        currentPage: 1,
        loading: false,
        error: null,
        errorsFormCampaign: null
    }),
    actions: {
        async createCampaign(dataCampaign: object) {
            this.loading = true;
            this.errorsFormCampaign = null
            try {
                return postMultiPartData("/campaigns", dataCampaign)
            } catch (error) {
                if (error instanceof AxiosError) {
                    this.errorsFormCampaign = error.response?.data.errors
                }
            } finally {
                this.loading = false;
            }

        },
        async getCampaigns(page: number | string) {
            this.loading = true
            try {
                const response = await fetchData(`/campaigns?page=${page}`)
                this.campaigns = response
                this.totalItems = response.meta.total
            } catch (error) {
                console.log(this.error = "Erreur lors de la récupération des cagnottes")
            } finally {
                this.loading = false
            }
        },
        async getOneCampaign(slug: string, id: string) {
            this.loading = true
            try {
                const response = await fetchData(`/campaigns/${slug}-${id}`)
                if (response) {
                    this.campaign = response.data as Campaign
                }
            } catch (error) {
                console.log(this.error = "Erreur lors de la récupération de la cagnotte")
            } finally {
                this.loading = false
            }
        },
        async setPage(page: number | string) {
            this.currentPage = page
            await this.getCampaigns(page)
        }
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useCampaignStore, import.meta.hot))
}