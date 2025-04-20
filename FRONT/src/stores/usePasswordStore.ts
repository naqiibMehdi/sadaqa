import {acceptHMRUpdate, defineStore} from "pinia";
import {postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";

interface propState {
  message: string | null
  errorsForget: string[] | null
  errorsReset: string | null
  loading: boolean
}

export const usePasswordStore = defineStore("password", {
  state: (): propState => ({
    message: null,
    errorsForget: null,
    errorsReset: null,
    loading: false
  }),
  actions: {
    async sendEmailToResetPassword(data: { email: string }) {
      this.errorsForget = null
      this.loading = true
      this.message = null
      try {
        const response = await postData("forgot-password", data)
        this.message = response.message
      } catch (e) {
        if (e instanceof AxiosError) {
          this.errorsForget = e.response?.data.email
        }
      } finally {
        this.loading = false
      }
    },

    async resetPassword(data: { password: string, password_confirmation: string }, token: string, email: string) {
      this.errorsReset = null
      this.loading = true
      this.message = null
      try {
        const response = await postData(`reset-password?token=${token}&email=${email}`, data)
        this.message = response.message
      } catch (e) {
        if (e instanceof AxiosError) {
          this.errorsReset = e.response?.data.errors?.password[0] || e.response?.data.message
        }
      } finally {
        this.loading = false
      }
    }
  },
  getters: {}
  
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(usePasswordStore, import.meta.hot))
}