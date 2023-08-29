<template>
  <div class="flex justify-center items-center mt-52">
    <div class="w-full max-w-xs">
      <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="auth.login()">
        <div class="identity-input mb-4">
          <label for="login" class="block text-gray-700 text-sm font-bold mb-2">Login</label>
          <input
              id="login"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
              type="text"
              placeholder="Login"
              aria-describedby="loginHelp"
              v-model="signInData.login"
          />
          <span class="text-xs text-red-700" id="loginHelp"></span>
        </div>

        <div class="password-input mb-6">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input
              aria-describedby="passwordHelp"
              v-model="signInData.password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              type="password"
              placeholder="*******"
          />
          <span class="text-xs text-red-700" id="passwordHelp"></span>
        </div>

        <div class="flex items-center justify-between">
          <button class="bg-blue-600 hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Sign In</button>
          <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
  import {ref, reactive} from "vue";
  import {useAuthStore} from "@/stores/auth";

  const auth = useAuthStore();

  const signInData = reactive(auth.getCredentials)
</script>

<style scoped>

</style>