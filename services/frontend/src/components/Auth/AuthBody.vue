<template>
  <div>
    <input v-model="credentials.login">
  </div>
  <div>
    <input v-model="credentials.password">
  </div>
</template>

<script setup>
  import {ref, reactive} from "vue";

  const credentials = reactive({
    login: null,
    password: null,
  });
</script>

<style scoped>

</style>