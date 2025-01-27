import {defineStore} from "pinia";
import api from "@/utils/axios.ts";
import {AxiosError} from "axios";

interface RegisterUser {
    name: string,
    first_name: string,
    public_name: string,
    email: string,
    password: string,
    password_confirmation: string,
    birth_date: string
}

interface ErrorsRegister {
    [key: string]: string[]
}

export const useAuthStore = defineStore("auth", {
    state: (): { errors: ErrorsRegister, status: string, message: string } => ({
        errors: {},
        status: "",
        message: ""
    }),
    actions: {
        createUser: async function (userData: RegisterUser) {
            this.status = "loading"
            try {
                const response = await api.post("/auth/register", userData);
                console.log(response)
                this.status = "success"
            } catch (e) {
                if (e instanceof AxiosError) {
                    this.errors = e.response?.data?.errors
                    this.status = "error"
                } else {
                    console.error("une erreur")
                }
            }
        }
    },
    getters: {}
})