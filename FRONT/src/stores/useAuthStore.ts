import {acceptHMRUpdate, defineStore} from "pinia";
import {postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import {RegisterUser} from "@/types/types.ts";

interface ErrorsRegister {
  [key: string]: string[]
}

export const useAuthStore = defineStore("auth", {
  state: (): {
    errors: ErrorsRegister | null,
    loading: boolean,
    error: string | null,
    token: string
  } => ({
    errors: null,
    loading: false,
    error: null,
    token: ""
  }),
  actions: {
    async createUser(userData: RegisterUser) {
      this.loading = true
      this.error = null
      try {
        await postData("/auth/register", userData);
      } catch (err) {
        if (err instanceof AxiosError) {
          this.error = err.message
          this.errors = err.response?.data?.errors;
        }
      } finally {
        this.loading = false
      }
    },

    async loginUser(userData: object) {
      this.loading = true
      this.error = null
      this.errors = {}
      try {
        const response = await postData("/auth/login", userData);
        this.error = response.message
        this.token = response.token;
      } catch (err) {
        if (err instanceof AxiosError) {
          this.errors = err.response?.data?.errors;
        }
      } finally {
        this.loading = false
      }
    },

    async logoutUser(userData: object) {
      this.loading = true
      try {
        await postData("/auth/logout", userData);
        this.token = "";
      } catch (err) {
        if (err instanceof AxiosError) {
          this.errors = err.response?.data?.errors;
        }
      } finally {
        this.loading = false
      }
    }
  },
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))
}