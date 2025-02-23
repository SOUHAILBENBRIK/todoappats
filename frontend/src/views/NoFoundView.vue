<script setup lang="ts">
import { useRouter } from 'vue-router'
const router = useRouter();
function goHome() {
  router.push('/');
}
</script>

<template>
  <div class="h-full w-full flex flex-col justify-center items-center">
    <h1 class="text-4xl font-bold text-black pb-8">404 - Not Found</h1>
    <p class="text-2xl font-bold text-gray-800 pb-8">
      The page you are looking for might have been removed, had its name changed or is temporarily
      unavailable.
    </p>
    <button class="text-white bg-gray-900 p-4 rounded-xl" @click="goHome">Back To Home Page</button>
  </div>
</template>
