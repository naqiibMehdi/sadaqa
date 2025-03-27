import {acceptHMRUpdate, defineStore} from "pinia";
import {fetchData, postMultiPartData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import {Address} from "@/types/types.ts";

interface propState {
    address: Address | null,
    errorsAddress: {
        address: string[],
        city: string[],
        postal_code: string[],
        country: string[],
        user_id: string[]
    } | null,
    message: string,
    loading: boolean
}

export const useAddressStore = defineStore("address", {
    state: (): propState => ({
        address: null,
        errorsAddress: null,
        message: "",
        loading: false
    }),
    actions: {
        async getAddress() {
            try {
                const response = await fetchData("user/address");
                this.address = response.data
                console.log(response)
            } catch (err) {
                if (err instanceof AxiosError) {
                    this.errorsAddress = err.response?.data.errors
                }
            }
        },
        async registerAddress(dataAddress: Address) {
            this.loading = true
            try {
                const response = await postMultiPartData("user/address", dataAddress);
                this.address = response.data
                this.message = response.message
                this.errorsAddress = null
            } catch (err) {
                if (err instanceof AxiosError) {
                    this.errorsAddress = err.response?.data.errors
                }
            } finally {
                this.loading = false
            }
        },


    },
    getters: {}
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useAddressStore, import.meta.hot))
}