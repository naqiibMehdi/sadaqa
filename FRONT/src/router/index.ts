import FormLoginView from "@/pages/FormLoginView.vue";
import FormRegisterView from "@/pages/FormRegisterView.vue";
import FormContact from "@/pages/FormContactView.vue";
import {createRouter, createWebHistory} from "vue-router"


const routes = [
    {path: "/login", name: "login", component: FormLoginView},
    {path: "/register", name: "register", component: FormRegisterView},
    {path: "/contact", name: "contact", component: FormContact},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router