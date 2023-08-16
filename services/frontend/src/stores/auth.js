import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    credentials: {
      login: null,
      password: null
    }
  }),

  getters: {
    getCredentials(state) {
      return state.credentials
    }
  },

  actions: {
    async login(){
      const response = await axios.get(
          "http://api-gateway.local/api/auth"
      );
    }
  }
})



