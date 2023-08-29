<script setup>
  import {useUserStore} from "@/stores/user";

  const user = useUserStore()
  user.me()
</script>

<template>
  <h1>Home</h1>
  <div>
    {{user.getUser}}
  </div>
</template>

<style scoped>

</style>