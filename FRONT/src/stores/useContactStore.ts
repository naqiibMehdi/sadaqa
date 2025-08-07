import {acceptHMRUpdate, defineStore} from "pinia";
import {postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";


interface propState {
  loading: boolean,
  errors: { email: string[], description: string[] } | null,
}

export const useContactStore = defineStore("contact", {
  state: (): propState => ({
    loading: false,
    errors: null,
  }),
  actions: {
    async sendContact(data: { email: string, description: string }) {
      this.loading = true
      this.errors = null
      try {
        await postData("contact", data)

      } catch (error) {
        if (error instanceof AxiosError) {
          this.errors = error.response?.data.errors
          console.log(this.errors)
        }
      } finally {
        this.loading = false
      }
    }
  },
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useContactStore, import.meta.hot))
}