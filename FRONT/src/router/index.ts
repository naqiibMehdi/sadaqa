import {createRouter, createWebHistory} from "vue-router"
import {useAuthStore} from "@/stores/useAuthStore.ts";
import {titleAndMetaTag} from "@/utils/functions.ts";
import {setDefaultMeta} from "@/utils/meta.ts";


const routes = [
  {
    path: "/",
    name: "home",
    component: () => import("@/pages/home/HomeView.vue"),
    meta: {
      title: "Faites votre premier pas en faisant un don pour un projet ou une association.",
      description: "Sadaqa est une association à but non lucratif dédiée à faciliter les dons et à créer des ponts entre les donateurs et les projets qui ont besoin de soutien"
    }
  },
  {
    path: "/privacy-policy",
    name: "privacy",
    component: () => import("@/pages/ressources/PolicyPrivacyView.vue"),
    meta: {
      title: "Politique de confidentialité",
      description: "Bienvenue sur Saddaqa, un site de financement participatif. Nous nous engageons à protéger la confidentialité et la sécurité de vos informations personnelles"
    }
  },

  {
    path: "/about",
    name: "about",
    component: () => import("@/pages/ressources/AboutView.vue"),
    meta: {
      title: "A propos de nous",
      description: "Sadaqa, qui signifie \"charité\" ou \"aumône\" en arabe, est une jeune association à but non lucratif\n" +
          "dédiée à faciliter les dons et à créer des ponts entre les donateurs et les projets qui ont besoin\n" +
          "de soutien."
    }
  },
  {
    path: "/rgpd",
    name: "rgpd",
    component: () => import("@/pages/ressources/RGPDView.vue"),
    meta: {
      title: "RGPD - Protection des données - Sadaqa",
      description: "Le Règlement Général sur la Protection des Données (RGPD) est un texte réglementaire européen qui encadre le traitement des données personnelles sur le territoire de l'Union européenne. "
    }
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/pages/forms/FormLoginView.vue"),
    meta: {requireAuth: false, title: "Connexion", description: "Se connecter à votre compte."}
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/pages/forms/FormRegisterView.vue"),
    meta: {
      requireAuth: false,
      title: "Créer un compte",
      description: "Créer votre compte afin de pouvoir créer une cagnotte."
    }
  },
  {
    path: "/forget-password",
    name: "password.forget",
    component: () => import("@/pages/forms/FormForgetPassword.vue"),
    meta: {
      title: "Mot de passe oublié",
      description: "Saisissez votre email afin de recevoir un mail de réinitialisation de mot de passe."
    }
  },
  {
    path: "/reset-password",
    name: "password.reset",
    component: () => import("@/pages/forms/FormResetPassword.vue"),
    meta: {title: "Réinitialisation mot de passe", description: "Saisissez votre nouveau mot de passe."}
  },
  {
    path: "/contact",
    name: "contact",
    component: () => import("@/pages/forms/FormContactView.vue"),
    meta: {title: "Contact", description: "C'est ici que vous pouvez nous contacter"}
  },
  {
    path: "/create-campaign",
    name: "createcampaign",
    component: () => import("@/pages/forms/FormCreateCampaignView.vue"),
    meta: {
      requireAuth: true,
      title: "Créer une cagnotte",
      description: "Remplissez ce formulaire afin de pouvoir créer votre cagnotte"
    }
  },
  {
    path: "/campaigns/:category([a-z]*)?",
    name: "campaigns",
    component: () => import("@/pages/campaigns/CampaignsView.vue"),
    meta: {title: "Cagnottes", description: "Voici la liste de toutes les cagnottes disponibles"}
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)",
    name: "campaign",
    component: () => import("@/pages/campaigns/CampaignView.vue"),
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/edit",
    name: "campaign.update",
    component: () => import("@/pages/forms/FormUpdateCampaignView.vue"),
    meta: {requireAuth: true, title: "Modifier votre cagnotte", description: "Modifier votre cagnotte"}
  },
  {
    path: "/campaigns/:slug([a-zA-Z0-9-]+)-:id([0-9]+)/payment",
    name: "payment",
    component: () => import("@/pages/forms/FormPaymentView.vue"),
    meta: {title: "Paiement", description: "Offrez votre don"}
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: () => import("@/pages/dashboard/DashBoardView.vue"),
    meta: {requireAuth: true, title: "Tableau de bord", description: "Vooici votre tableau de bord"}
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
        component: () => import("@/pages/user/ProfilView.vue"),
        meta: {title: "Profile", description: "Gérer votre profile"}
      },
      {
        path: "address",
        name: "address",
        component: () => import("@/pages/user/AddressView.vue"),
        meta: {title: "Adresse", description: "Gérer votre adresse"}
      },
      {
        path: "bank-account",
        name: "iban",
        component: () => import("@/pages/user/IbanView.vue"),
        meta: {title: "Coordonnées bancaire", description: "Gérer vos coordonnées bancaires"}
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
    component: () => import("@/pages/error/ErrorView.vue"),
    meta: {title: "Erreur 404", description: "Page introuvable"}
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, _, next) => {
  const authStore = useAuthStore()
  const hasToken = authStore.token || localStorage.getItem("token")
  titleAndMetaTag("Saddaqa - " + to.meta.title as string, to.meta.description as string)
  setDefaultMeta()

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