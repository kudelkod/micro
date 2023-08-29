import {defineStore} from "pinia";
import axios from "axios";
import router from "@/router";

export const useUserStore = defineStore('user', {
    state: () => ({
       user: null
    }),

    getters: {
        getCUser(state) {
            return state.user
        },

    },

    actions: {
        async me(){
            const response = await axios.get(
                "http://api-gateway.local/api/user/me",
                {
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`
                    }
                }
            );

            const data = response.data
            localStorage.setItem('access_token', data.access_token)
            localStorage.setItem('refresh_token', data.refresh_token)
            await router.push({name: 'Home'})
        },
    }
})