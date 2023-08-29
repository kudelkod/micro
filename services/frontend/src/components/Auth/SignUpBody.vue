<script setup>
import {computed, reactive} from "vue";
import {useAuthStore} from "@/stores/auth";
import {email, required, sameAs} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useToast} from "vue-toastification";

  const auth = useAuthStore();
  const toast = useToast();
  const state = reactive(auth.registrationData);

  const rules = {
      name: {required},
      email: {required, email},
      password: {required},
      confirmPassword: {required, sameAs: sameAs(computed(() => state.password))}
  }

  const $v = useVuelidate(rules, state)

  function signUp(invalid){
    if(invalid)
    {
      toast.error('There are invalid fields')
      return null;
    }
    auth.register();
  }
</script>

<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm p-5 rounded-lg shadow-lg">
      <form class="space-y-6" @submit.prevent="signUp($v.$invalid)">
        <div>
          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
          <div class="mt-2">
            <input v-model="$v.name.$model" id="name" name="name" type="text" autocomplete="name" required="" :class="{
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1' : !$v.name.$error && $v.name.$dirty,
              'text-sm sm:text-base relative w-full border border-red-400 rounded placeholder-gray-400 focus:border-red-400 focus:outline-none py-1 pr-1 pl-1' : $v.name.$error,
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1 mt' : !$v.name.$error && !$v.name.$dirty,
            }"/>
            <div class="flex w-full" v-for="(error, index) in $v.name.$errors" :key="index">
              <span class="text-sm hover:text-base text-red-400 mt-1">{{ error.$message }}</span>
            </div>
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input v-model="$v.email.$model" id="email" name="email" type="email" autocomplete="email" required="" :class="{
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1' : !$v.email.$error && $v.email.$dirty,
              'text-sm sm:text-base relative w-full border border-red-400 rounded placeholder-gray-400 focus:border-red-400 focus:outline-none py-1 pr-1 pl-1' : $v.email.$error,
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1 mt' : !$v.email.$error && !$v.email.$dirty,
            }"/>
            <div class="flex w-full" v-for="(error, index) in $v.email.$errors" :key="index">
              <span class="text-sm hover:text-base text-red-400 mt-1">{{ error.$message }}</span>
            </div>
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="mt-2">
            <input v-model="$v.password.$model" id="password" name="password" type="password" autocomplete="password" required="" :class="{
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1' : !$v.password.$error && $v.password.$dirty,
              'text-sm sm:text-base relative w-full border border-red-400 rounded placeholder-gray-400 focus:border-red-400 focus:outline-none py-1 pr-1 pl-1' : $v.password.$error,
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1 mt' : !$v.password.$error && !$v.password.$dirty,
            }"/>
            <div class="flex w-full" v-for="(error, index) in $v.password.$errors" :key="index">
              <span class="text-sm hover:text-base text-red-400 mt-1">{{ error.$message }}</span>
            </div>
          </div>
        </div>

        <div>
          <label for="confirm_password" class="block text-sm font-medium leading-6 text-gray-900">Confirm password</label>
          <div class="mt-2">
            <input v-model="$v.confirmPassword.$model" id="confirm_password" name="confirm_password" type="password" autocomplete="confirm_password" required="" :class="{
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1' : !$v.confirmPassword.$error && $v.confirmPassword.$dirty,
              'text-sm sm:text-base relative w-full border border-red-400 rounded placeholder-gray-400 focus:border-red-400 focus:outline-none py-1 pr-1 pl-1' : $v.confirmPassword.$error,
              'text-sm sm:text-base relative w-full border rounded placeholder-gray-400 focus:border-indigo-400 focus:outline-none py-1 pr-1 pl-1 mt' : !$v.confirmPassword.$error && !$v.confirmPassword.$dirty,
            }"/>
            <div class="flex w-full" v-for="(error, index) in $v.confirmPassword.$errors" :key="index">
              <span class="text-sm hover:text-base text-red-400 mt-1">{{ error.$message }}</span>
            </div>
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</button>
        </div>
      </form>

      <p class="mt-8 text-center text-sm text-gray-500">
        Have an account?
        <router-link class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500 hover:underline hover:shadow-sm" :to="{name: 'SignIn'}">Sign In</router-link>
      </p>
    </div>
  </div>
</template>

<style scoped>

</style>