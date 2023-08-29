import { createRouter, createWebHistory } from 'vue-router'
import Auth from "../views/Auth/SignIn.vue";
import Registration from "@/views/Auth/SignUp.vue";
import Home from "@/views/Home/Home.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/sign_in',
      name: 'SignIn',
      component: Auth
    },
    {
      path:'/sign_up',
      name: 'SignUp',
      component: Registration
    },
  ]
})

export default router
