import {acceptHMRUpdate, defineStore} from "pinia";
import {postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";

interface propState {
  loading: boolean,
  errors: [] | null,
  errorMessage: string | null,
}

export const useRecoveryStore = defineStore("recovery", {
  state: (): propState => ({
    loading: false,
    errors: null,
    errorMessage: null,
  }),
  actions: {

    async registerRecovery(idCampaign: string | number, dataRecovery: { iban: string }) {
      this.loading = true
      this.errors = null
      this.errorMessage = null
      
      try {
        const response = await postData(`recovery/${idCampaign}`, dataRecovery);
        console.log(response)
      } catch (err) {
        if (err instanceof AxiosError) {
          if ([404, 403].includes(err.response?.status as number)) {
            this.errorMessage = err.response?.data.message
          } else {
            this.errors = err.response?.data?.errors?.iban
          }
          console.log(err.response)
        }
      } finally {
        this.loading = false
      }
    }
  },
  getters: {}
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useRecoveryStore, import.meta.hot))
}