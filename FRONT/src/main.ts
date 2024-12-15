import {createApp} from 'vue'
import '@/style.css'
import App from '@/App.vue'
import router from "@/router/index.ts"

// import Primevue
import "primeicons/primeicons.css"
import PrimeVue from "primevue/config"
import Aura from "@primevue/themes/aura"

const app = createApp(App)

app
    .use(PrimeVue, {
        theme: {
            preset: Aura,
            options: {
                darkModeSelector: false
            }
        }
    })
    .use(router)
    .mount('#app')
