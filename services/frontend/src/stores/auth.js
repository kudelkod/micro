import { defineStore } from 'pinia'
import axios from 'axios'
import {useToast} from "vue-toastification";

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
          "http://api-gateway.local/api/auth"
      );
    },
    async register(){
      try{
        const response = await axios.post(
            "http://api-gateway.local/api/user/register",
            this.registrationData
        );
        const data = response.data

        toast.success(data.message)
      }
      catch (e) {
        toast.error(e.message)
      }
    }
  }
})



