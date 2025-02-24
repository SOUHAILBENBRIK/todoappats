<script setup lang="ts">
import { useRouter } from 'vue-router'
const props = defineProps({
  error: String,
  statusCode: String,
  path: String,
})
const router = useRouter()

function goHome() {
  router.push(props)
}
</script>

<template>
  <div
    class="w-full h-full shadow-2xl bg-white rounded-lg flex flex-col justify-center items-center gap-2"
  >
    <p class="text-2xl font-bold text-black">Error {{ statusCode }}</p>
    <p class="text-lg text-black">{{ error }}</p>
    <button class="text-white bg-red-400 p-4 rounded-xl" @click="goHome">Back To Home Page</button>
  </div>
</template>
