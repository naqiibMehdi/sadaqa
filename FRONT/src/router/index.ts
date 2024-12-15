import FormLoginView from "@/pages/FormLoginView.vue";
import {createRouter, createWebHistory} from "vue-router"


const routes = [
    {path: "/login", component: FormLoginView}
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router