import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData, postMultiPartData} from "@/utils/axios.ts";
import type {Campaign, errorsFormCampaign} from "@/types/types.ts";
import {AxiosError} from "axios";

export const useCampaignStore = defineStore("campaign", {
  state: (): {
    campaigns: { data: Campaign[], links: {}, meta: {} },
    campaign: Campaign | null,
    totalItems: number,
    itemsPerPage: number,
    currentPage: number,
    loading: boolean,
    error: string | null,
    errorsFormCampaign: errorsFormCampaign | null,
    successMessage: string | null
  } => ({
    campaigns: {data: [], links: {}, meta: {}},
    campaign: null,
    totalItems: 0,
    itemsPerPage: 9,
    currentPage: 1,
    loading: false,
    error: null,
    errorsFormCampaign: null,
    successMessage: null
  }),
  actions: {
    async createCampaign(dataCampaign: object) {
      this.loading = true;
      this.errorsFormCampaign = null
      try {
        return await postMultiPartData("/campaigns", dataCampaign)
      } catch (error) {
        if (error instanceof AxiosError) {
          this.errorsFormCampaign = error.response?.data?.errors
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
        this.currentPage = page as number
      } catch (error) {
        console.log(this.error = "Erreur lors de la récupération des cagnottes")
      } finally {
        this.loading = false
      }
    },
    async getOneCampaign(slug: string, id: string) {
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

    async UpdateOneCampaign(slug: string, id: string, dataCampaign: object) {
      this.loading = true;
      this.errorsFormCampaign = null
      try {
        const response = await postMultiPartData(`/campaigns/${slug}-${id}/edit?_method=PUT`, dataCampaign)
        this.campaign = response.data
        this.successMessage = response.message
      } catch (error) {
        if (error instanceof AxiosError) {
          this.errorsFormCampaign = error.response?.data?.errors
        }
      } finally {
        this.loading = false;
      }

    },
    async setPage(page: number) {
      this.currentPage = page
      await this.getCampaigns(page)
    }
  },
  getters: {
    campaignsHome(): { title: string, target_amount: number, collected_amount: number, url_image: string }[] {
      const tab = this.campaigns.data?.map(({title, target_amount, collected_amount, url_image}) => ({
        title,
        target_amount,
        collected_amount,
        url_image
      }))

      return tab?.slice(0, 3)
    }
  }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useCampaignStore, import.meta.hot))
}