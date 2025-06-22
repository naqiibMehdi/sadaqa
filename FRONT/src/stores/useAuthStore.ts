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
    token: string,
    tokenExpiryTimeoutId: number | null
  } => ({
    errors: null,
    loading: false,
    error: null,
    token: "",
    tokenExpiryTimeoutId: null
  }),
  actions: {
    async createUser(userData: RegisterUser) {
      this.loading = true
      this.error = null
      try {
        await postData("/auth/register", userData);
        this.errors = null
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
        await this.setToken(response.token)
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
        this.removeToken()
      } catch (err) {
        if (err instanceof AxiosError) {
          this.errors = err.response?.data?.errors;
        }
      } finally {
        this.loading = false
      }
    },

    async setToken(token: string) {
      const expiryTime = Date.now() + (60 * 60 * 1000);
      localStorage.setItem("token", token);
      localStorage.setItem("tokenExpiry", expiryTime.toString());
      await this.setupTokenExpiry();
    },

    async setupTokenExpiry() {
      // Annuler tout compteur existant
      if (this.tokenExpiryTimeoutId !== null) {
        clearTimeout(this.tokenExpiryTimeoutId);
      }

      const expiryTimeStr = localStorage.getItem("tokenExpiry");
      if (!expiryTimeStr) return;

      const expiryTime = parseInt(expiryTimeStr);
      const currentTime = Date.now();
      const timeLeft = expiryTime - currentTime;

      // Si le token est déjà expiré
      if (timeLeft <= 0) {
        await this.logoutUser({});
        return;
      }

      // Configurer un nouveau compteur avec le temps restant
      this.tokenExpiryTimeoutId = setTimeout(async () => {
        await this.logoutUser({});
      }, timeLeft) as unknown as number;
    },

    removeToken() {
      localStorage.removeItem("token");
      localStorage.removeItem("tokenExpiry");
      if (this.tokenExpiryTimeoutId !== null) {
        clearTimeout(this.tokenExpiryTimeoutId);
        this.tokenExpiryTimeoutId = null;
      }
    },

    // Méthode à appeler lors de l'initialisation de l'application
    async initializeAuth() {
      const token = localStorage.getItem("token");
      if (token) {
        this.token = token;
        await this.setupTokenExpiry();
      }
    }

    ,
  },
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))
}