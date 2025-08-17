import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData, postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import {CampaignRecovery} from "@/types/types.ts";
import {useUserStore} from "@/stores/useUserStore.ts";


const userStore = useUserStore()

interface propState {
  recoveries: { id: number, title: string, created_at: string, total_amount: number, status: string }[] | null,
  loading: boolean,
  errors: [] | null,
  errorMessage: string | null,
}

export const useRecoveryStore = defineStore("recovery", {
  state: (): propState => ({
    recoveries: null,
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
        await postData(`recovery/${idCampaign}`, dataRecovery);
        await userStore.updateRecoveryCampaign(idCampaign)

      } catch (err) {
        if (err instanceof AxiosError) {
          if ([404, 403].includes(err.response?.status as number)) {
            this.errorMessage = err.response?.data.message
          } else {
            this.errors = err.response?.data?.errors?.iban
          }
        }
      } finally {
        this.loading = false
      }
    },

    async getRecoveries() {
      this.loading = true
      this.recoveries = []
      try {
        const response = await fetchData("recoveries");
        response.data.forEach((recovery: CampaignRecovery) => {
          const {id, campaign, created_at, total_amount, status} = recovery
          this.recoveries?.push({id, title: campaign?.title as string, created_at, total_amount, status})
        })
      } catch (err) {
        if (err instanceof AxiosError) {
          this.recoveries = null
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