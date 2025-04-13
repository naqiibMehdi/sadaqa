import {acceptHMRUpdate, defineStore} from "pinia";
import {postData} from "@/utils/axios.ts";
import {AxiosError} from "axios";
import {loadStripe} from "@stripe/stripe-js";

interface typeState {
  errors: { name: string, email: string, amount: number }
  loading: boolean
}

const stripePromise = loadStripe("pk_test_51Qh6JuHlYuDYyetWvKUWgjvatxrw7G0g1QqDmHq7brMG9rh1JgzP7C6KZKVuPnaElb2ZJECxZpZY8xYfr3wM4CZC00kQTSbu28")

export const usePaymentStore = defineStore("payment", {
  state: (): typeState => ({
    errors: {name: "", email: "", amount: 0},
    loading: false
  }),
  actions: {
    async checkoutSessionPayment(
        slug: string,
        id: string,
        paymentData: { name: string, email: string, amount: number }
    ) {
      this.loading = true
      this.errors = {name: "", email: "", amount: 0}
      try {
        const response = await postData(`/campaigns/${slug}-${id}/payment`, paymentData)
        const idStripe = response.session_checkout_id
        const stripe = await stripePromise

        await stripe?.redirectToCheckout({sessionId: idStripe})

        console.log(idStripe)
      } catch (error) {
        if (error instanceof AxiosError) {
          this.errors.name = error.response?.data?.name?.[0]
          this.errors.email = error.response?.data?.email?.[0]
          this.errors.amount = error.response?.data?.amount?.[0]
        }
      } finally {
        this.loading = false
      }
    }
  },
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(usePaymentStore, import.meta.hot))
}