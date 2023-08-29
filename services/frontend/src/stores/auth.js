import { defineStore } from 'pinia'
import axios from 'axios'
import {useToast} from "vue-toastification";
import router from "@/router";

const toast = useToast();

export const useAuthStore = defineStore('auth', {
  state: () => ({
    credentials: {
      login: null,
      password: null
    },
    registrationData: {
      name: null,
      login: null,
      email: null,
      password: null,
    },
  }),

  getters: {
    getCredentials(state) {
      return state.credentials
    },
    getRegistrationData(state) {
      return state.registrationData
    }
  },

  actions: {
    async login(){
      const response = await axios.post(
          "http://api-gateway.local/api/auth/login",
          this.credentials
      );

      const data = response.data
      localStorage.setItem('access_token', data.access_token)
      localStorage.setItem('refresh_token', data.refresh_token)

      await router.push({name: 'Home'})
    },

    async register(){
      try{
        const response = await axios.post(
            "http://api-gateway.local/api/auth/register",
            this.registrationData
        );
        const data = response.data
        await router.push({name: 'SignIn'})
        toast.success(data.message)
      }
      catch (e) {
        toast.error(e.message)
      }
    }
  }
})



