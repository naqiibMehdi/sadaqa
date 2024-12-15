import FormLoginView from "@/pages/FormLoginView.vue";
import FormRegister from "@/pages/FormRegister.vue";
import {createRouter, createWebHistory} from "vue-router"


const routes = [
    {path: "/login", name: "login", component: FormLoginView},
    {path: "/register", name: "register", component: FormRegister},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router