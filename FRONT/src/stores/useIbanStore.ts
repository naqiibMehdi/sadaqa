import {acceptHMRUpdate, defineStore} from "pinia";
import {deleteData, fetchData, postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";

interface propState {
  iban: string | null
  errorsIban: string[],
  message: string | null
  loading: boolean
}

export const useIbanStore = defineStore("iban", {
  state: (): propState => ({
    iban: null,
    errorsIban: [],
    message: null,
    loading: false
  }),
  actions: {
    async getIban() {
      try {
        const response = await fetchData("user/iban");
        this.iban = response.data.iban
      } catch (err) {
        if (err instanceof AxiosError) {
          this.message = "Impossible de récupérer l'iban"
        }
      }
    },

    async registerIban(dataIban: { iban: string }) {
      this.loading = true
      try {
        const response = await postData("user/iban", dataIban);
        this.iban = response.data
        this.message = response.message
        this.errorsIban = []
      } catch (err) {
        if (err instanceof AxiosError) {
          console.log(err.response?.data.errors)
          this.errorsIban = err.response?.data.errors.iban
        }
      } finally {
        this.loading = false
      }
    },

    async editIban(dataIban: { iban: string }) {
      this.loading = true
      try {
        const response = await postData("user/iban/edit?_method=PUT", dataIban);
        this.iban = response.data
        this.message = response.message
        this.errorsIban = []
      } catch (err) {
        if (err instanceof AxiosError) {
          console.log(err.response?.data.errors)
          this.errorsIban = err.response?.data.errors.iban
        }
      } finally {
        this.loading = false
      }
    },

    async deleteIban(dataIban: {}) {
      this.loading = true
      try {
        const response = await deleteData("user/iban", dataIban);
        this.message = response.message
        this.iban = null
      } catch (err) {
        if (err instanceof AxiosError) {
          console.log(err.response?.data.errors)
          this.errorsIban = err.response?.data.errors.iban
        }
      } finally {
        this.loading = false
      }
    }


  },
  getters: {}
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useIbanStore, import.meta.hot))
}