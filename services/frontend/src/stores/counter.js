import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useCounterStore = defineStore('counter', {
  state: () => ({
    count: 0
  }),

  getters: {
    counter(state) {
      return state.count
    }
  },

  actions: {
    async increment(){
      const response = await axios.get(
          "http://api-gateway.local/api/book"
      );
      console.log(response)
      this.count = response.data
    }
  }
})



