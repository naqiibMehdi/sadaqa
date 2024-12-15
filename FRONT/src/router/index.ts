import FormConnexionView from "@/pages/FormConnexionView.vue";
import {createRouter, createWebHistory} from "vue-router"


const routes = [
  {path: "/register", component: FormConnexionView}
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router