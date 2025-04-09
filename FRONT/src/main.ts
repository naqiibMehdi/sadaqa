import {createApp} from 'vue'
import '@/style.css'
import App from '@/App.vue'
import router from "@/router/index"
import {createPinia} from "pinia"

import "primeicons/primeicons.css"
import ToastService from 'primevue/toastservice';
import ConfirmationService from "primevue/confirmationservice"
import PrimeVue from "primevue/config"
import Tooltip from 'primevue/tooltip';
import Aura from "@primevue/themes/aura"

const app = createApp(App)

const pinia = createPinia()

app
    .use(pinia)
    .use(router)
    .use(ToastService)
    .use(ConfirmationService)
    .directive("tooltip", Tooltip)
    .use(PrimeVue, {
        theme: {
            preset: Aura,
            options: {
                darkModeSelector: false
            }
        }
    })
    .mount('#app')
