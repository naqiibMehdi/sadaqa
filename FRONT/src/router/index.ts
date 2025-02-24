import FormLoginView from "@/pages/forms/FormLoginView.vue";
import FormRegisterView from "@/pages/forms/FormRegisterView.vue";
import FormContact from "@/pages/forms/FormContactView.vue";
import {createRouter, createWebHistory} from "vue-router"
import FormCreateCampaignView from "@/pages/forms/FormCreateCampaignView.vue";
import FormUpdateCampaignView from "@/pages/forms/FormUpdateCampaignView.vue";
import ProfilView from "@/pages/profile/ProfilView.vue";
import FormPaymentView from "@/pages/forms/FormPaymentView.vue";
import CampaignsView from "@/pages/campaigns/CampaignsView.vue";
import CampaignView from "@/pages/campaigns/CampaignView.vue"
import DashBoardView from "@/pages/dashboard/DashBoardView.vue";
import FormForgetPassword from "@/pages/forms/FormForgetPassword.vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";


const routes = [
    {path: "/login", name: "login", component: FormLoginView, meta: {requireAuth: false}},
    {path: "/register", name: "register", component: FormRegisterView, meta: {requireAuth: false}},
    {path: "/forget-password", name: "forget-password", component: FormForgetPassword},
    {path: "/contact", name: "contact", component: FormContact},
    {path: "/create-campaign", name: "createcampaign", component: FormCreateCampaignView, meta: {requireAuth: true}},
    {path: "/profil", name: "profil", component: ProfilView, meta: {requireAuth: true}},
    {path: "/campaigns", name: "campaigns", component: CampaignsView},
    {
        path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)",
        name: "campaign",
        component: CampaignView,
    },
    {
        path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/edit",
        name: "campaign.update",
        component: FormUpdateCampaignView,
    },
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

    if ("requireAuth" in to.meta) {
        if (!to.meta.requireAuth && hasToken) {
            next({name: "dashboard"})
        } else if (to.meta.requireAuth && !hasToken) {
            next({name: "login"})
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router