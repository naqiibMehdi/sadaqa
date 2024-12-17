import FormLoginView from "@/pages/FormLoginView.vue";
import FormRegisterView from "@/pages/FormRegisterView.vue";
import FormContact from "@/pages/FormContactView.vue";
import {createRouter, createWebHistory} from "vue-router"
import FormCreateCampaignView from "@/pages/FormCreateCampaignView.vue";
import ProfilView from "@/pages/ProfilView.vue";


const routes = [
    {path: "/login", name: "login", component: FormLoginView},
    {path: "/register", name: "register", component: FormRegisterView},
    {path: "/contact", name: "contact", component: FormContact},
    {path: "/create-campaign", name: "createcampaign", component: FormCreateCampaignView},
    {path: "/profil", name: "profil", component: ProfilView},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router