import {createRouter, createWebHistory} from "vue-router"
import {useAuthStore} from "@/stores/useAuthStore.ts";


const routes = [
  {path: "/", name: "home", component: () => import("@/pages/home/HomeView.vue")},
  {
    path: "/login",
    name: "login",
    component: () => import("@/pages/forms/FormLoginView.vue"),
    meta: {requireAuth: false}
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/pages/forms/FormRegisterView.vue"),
    meta: {requireAuth: false}
  },
  {path: "/forget-password", name: "password.forget", component: () => import("@/pages/forms/FormForgetPassword.vue")},
  {path: "/reset-password", name: "password.reset", component: () => import("@/pages/forms/FormResetPassword.vue")},
  {path: "/contact", name: "contact", component: () => import("@/pages/forms/FormContactView.vue")},
  {
    path: "/create-campaign",
    name: "createcampaign",
    component: () => import("@/pages/forms/FormCreateCampaignView.vue"),
    meta: {requireAuth: true}
  },
  {path: "/campaigns", name: "campaigns", component: () => import("@/pages/campaigns/CampaignsView.vue")},
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)",
    name: "campaign",
    component: () => import("@/pages/campaigns/CampaignView.vue"),
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/edit",
    name: "campaign.update",
    component: () => import("@/pages/forms/FormUpdateCampaignView.vue"),
    meta: {requireAuth: true}
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/payment",
    name: "payment",
    component: () => import("@/pages/forms/FormPaymentView.vue"),
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("@/pages/dashboard/DashBoardView.vue"),
    meta: {requireAuth: true}
  },
  {
    path: "/account",
    name: "account",
    component: () => import("@/pages/user/AccountView.vue"),
    meta: {requireAuth: true},
    children: [
      {
        path: "profil",
        name: "profil",
        component: () => import("@/pages/user/ProfilView.vue")
      },
      {
        path: "address",
        name: "address",
        component: () => import("@/pages/user/AddressView.vue")
      },
      {
        path: "bank-account",
        name: "iban",
        component: () => import("@/pages/user/IbanView.vue")
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
    component: () => import("@/pages/error/ErrorView.vue")
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