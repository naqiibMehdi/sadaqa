import {createApp} from 'vue'
import '@/style.css'
import App from '@/App.vue'
import router from "@/router/index"

// import Primevue
import "primeicons/primeicons.css"
import PrimeVue from "primevue/config"
import Aura from "@primevue/themes/aura"

const app = createApp(App)

app
    .use(router)
    .use(PrimeVue, {
        theme: {
            preset: Aura,
            options: {
                darkModeSelector: false
            }
        }
    })
    .mount('#app')
