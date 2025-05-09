import FormLoginView from "@/pages/forms/FormLoginView.vue";
import FormRegisterView from "@/pages/forms/FormRegisterView.vue";
import FormContact from "@/pages/forms/FormContactView.vue";
import {createRouter, createWebHistory} from "vue-router"
import FormCreateCampaignView from "@/pages/forms/FormCreateCampaignView.vue";
import FormUpdateCampaignView from "@/pages/forms/FormUpdateCampaignView.vue";
import ProfilView from "@/pages/user/ProfilView.vue";
import FormPaymentView from "@/pages/forms/FormPaymentView.vue";
import CampaignsView from "@/pages/campaigns/CampaignsView.vue";
import CampaignView from "@/pages/campaigns/CampaignView.vue"
import DashBoardView from "@/pages/dashboard/DashBoardView.vue";
import FormForgetPassword from "@/pages/forms/FormForgetPassword.vue";
import FormResetPassword from "@/pages/forms/FormResetPassword.vue";
import AccountView from "@/pages/user/AccountView.vue";
import AddressView from "@/pages/user/AddressView.vue";
import IbanView from "@/pages/user/IbanView.vue";
import {useAuthStore} from "@/stores/useAuthStore.ts";
import ErrorView from "@/pages/error/ErrorView.vue";
import HomeView from "@/pages/home/HomeView.vue";


const routes = [
  {path: "/", name: "home", component: HomeView},
  {path: "/login", name: "login", component: FormLoginView, meta: {requireAuth: false}},
  {path: "/register", name: "register", component: FormRegisterView, meta: {requireAuth: false}},
  {path: "/forget-password", name: "password.forget", component: FormForgetPassword},
  {path: "/reset-password", name: "password.reset", component: FormResetPassword},
  {path: "/contact", name: "contact", component: FormContact},
  {path: "/create-campaign", name: "createcampaign", component: FormCreateCampaignView, meta: {requireAuth: true}},
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
    meta: {requireAuth: true}
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/payment",
    name: "payment",
    component: FormPaymentView
  },
  {path: "/dashboard", name: "dashboard", component: DashBoardView, meta: {requireAuth: true}},
  {
    path: "/account",
    name: "account",
    component: AccountView,
    meta: {requireAuth: true},
    children: [
      {
        path: "profil",
        name: "profil",
        component: ProfilView
      },
      {
        path: "address",
        name: "address",
        component: AddressView
      },
      {
        path: "bank-account",
        name: "iban",
        component: IbanView
      }
    ]
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/error-404"
  },
  {
    path: "/error-404",
    name: "error",
    component: ErrorView
  }
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