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
    successMessage: string | null,
    currentSearch: string | null,
    category: string | null,
    unauthorized: boolean,
  } => ({
    campaigns: {data: [], links: {}, meta: {}},
    campaign: null,
    totalItems: 0,
    itemsPerPage: 9,
    currentPage: 1,
    loading: false,
    error: null,
    errorsFormCampaign: null,
    successMessage: null,
    currentSearch: null,
    category: null,
    unauthorized: false,
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
    async getCampaigns(page: number | string, search?: string, category?: string) {
      if (
          this.loading ||
          (page.toString() === this.currentPage.toString() &&
              search === this.currentSearch &&
              category === this.category)
      ) {
        return; // Ne pas refaire la requête si les paramètres sont identiques
      }

      this.loading = true
      this.currentSearch = null
      this.category = null
      this.error = null


      try {
        let url = `/campaigns`

        if (category) {
          url += `/${category}`
          this.category = category
        }

        url += `?page=${page}`

        if (search) {
          url += `&search=${search}`
          this.currentSearch = search
        }

        const response = await fetchData(url)
        this.campaigns = response
        this.totalItems = response.meta.total
        this.currentPage = page as number

      } catch (error) {
        if (error instanceof AxiosError) {
          this.campaigns = {data: [], links: {}, meta: {}}
          this.error = error.response?.data?.message
        }

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

    async UpdateOneCampaign(slug: string, id: string, dataCampaign: object) {
      this.loading = true;
      this.errorsFormCampaign = null
      this.unauthorized = false

      try {
        const response = await postMultiPartData(`/campaigns/${slug}-${id}/edit?_method=PUT`, dataCampaign)
        this.campaign = response.data
        this.successMessage = response.message
      } catch (error) {
        if (error instanceof AxiosError) {
          if (error?.response?.status === 403) {
            this.unauthorized = true
          } else {
            this.errorsFormCampaign = error.response?.data?.errors
          }
        }
      } finally {
        this.loading = false;
      }

    },
    async closeCampaign(slug: string, id: string, dataCampaign: object) {
      this.loading = true;
      this.error = null
      this.unauthorized = false

      try {
        const response = await postMultiPartData(`/campaigns/${slug}-${id}?_method=DELETE`, dataCampaign)
        return {success: true, message: response.message}

      } catch (error) {
        if (error instanceof AxiosError) {
          console.log(error.response)
          if (error?.response?.status === 403) {
            this.unauthorized = true
          } else if (error?.response?.status === 401) {
            this.unauthorized = true
            this.error = error.response?.data?.message
          } else {
            this.error = error.response?.data?.errors
          }
        }

        return {success: false, message: this.error}
      } finally {
        this.loading = false;
      }

    },

    async setPage(page: number) {
      this.currentPage = page
      await this.getCampaigns(page, this.currentSearch || undefined, this.category || undefined)
    },

    setSearch(search: string) {
      this.currentSearch = search
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