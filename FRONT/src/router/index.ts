import FormLoginView from "@/pages/FormLoginView.vue";
import FormRegisterView from "@/pages/FormRegisterView.vue";
import FormContact from "@/pages/FormContactView.vue";
import {createRouter, createWebHistory} from "vue-router"
import FormCreateCampaignView from "@/pages/FormCreateCampaignView.vue";
import ProfilView from "@/pages/ProfilView.vue";
import FormPaymentView from "@/pages/FormPaymentView.vue";
import CampaignsView from "@/pages/CampaignsView.vue";
import CampaignView from "@/pages/CampaignView.vue"
import DashBoardView from "@/pages/DashBoardView.vue";
import FormForgetPassword from "@/pages/FormForgetPassword.vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";


const routes = [
    {path: "/login", name: "login", component: FormLoginView, meta: {requireAuth: false}},
    {path: "/register", name: "register", component: FormRegisterView, meta: {requireAuth: false}},
    {path: "/forget-password", name: "forget-password", component: FormForgetPassword},
    {path: "/contact", name: "contact", component: FormContact},
    {path: "/create-campaign", name: "createcampaign", component: FormCreateCampaignView, meta: {requireAuth: true}},
    {path: "/profil", name: "profil", component: ProfilView, meta: {requireAuth: true}},
    {path: "/campaigns", name: "campaigns", component: CampaignsView},
    {path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)", name: "campaign", component: CampaignView},
    {path: "/dashboard", name: "dashboard", component: DashBoardView, meta: {requireAuth: true}},
    {path: "/payment", name: "payment", component: FormPaymentView},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, _, next) => {
    const authStore = useAuthStore()
    const hasToken = authStore.token

    if (!to.meta.requireAuth && hasToken) {
        next({name: "dashboard"})
    } else if (to.meta.requireAuth && !hasToken) {
        next({name: "login"})
    } else {
        next()
    }
})

export default router