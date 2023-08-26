import { createRouter, createWebHistory } from 'vue-router'
import Auth from "../views/Auth.vue";
import Registration from "@/views/Registration.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/auth',
      name: 'Auth',
      component: Auth
    },
    {
      path:'/registration',
      name: 'Registration',
      component: Registration
    },
  ]
})

export default router
