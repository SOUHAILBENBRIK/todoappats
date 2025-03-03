<script setup>
import { useRouter, useRoute } from 'vue-router'

import userIcon from '../assets/icons/user.svg'
import { onMounted, ref, computed, watchEffect } from 'vue'
import { getUser } from '@/api/userApi'
const router = useRouter()
const route = useRoute()
const currentRoute = computed(() => route.path)
const userName = ref('')
const email = ref('')
const profile = ref(null)

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}

function getUserInfo() {
  getUser()
    .then((response) => {
      if (response.status === 200) {
        const user = JSON.parse(response.data.data)
        console.log('user', user)
        userName.value = user.username
        email.value = user.email
        profile.value = user.profileImage
      } else {
        console.log('response', response)
      }
    })
    .catch((err) => {
      console.log('error', err)
    })
}
watchEffect(() => {
  console.log('Route changed:', route.path)
})

onMounted(() => {
  getUserInfo()
})

const isActive = (path) => {
  return computed(() => {
    console.log(`Checking: ${path}, Current: ${route.path}`) // Debugging log
    return route.path === path
  })
}
</script>

<template>
  <div class="bg-gray-700 h-[93vh] flex flex-col justify-between items-start gap-5 w-[12vw] p-4">
    <!-- Profile -->
    <div class="flex flex-col items-center gap-2 w-full">
      <img
        :src="profile ? `http://localhost:8000${profile}` : userIcon"
        alt="Profile"
        class="bg-white rounded-full h-20 w-20"
      />
      <p class="text-white text-sm font-semibold overflow-ellipsis">{{ userName }}</p>
      <p class="text-white text-sm font-semibold overflow-ellipsis">{{ email }}</p>
    </div>

    <!-- Sidebar Navigation -->
    <div class="flex flex-col gap-4 w-full">
      <div
        :class="[
          'flex items-center gap-2 px-4 py-2 rounded-md cursor-pointer',
          isActive('/dashboard').value ? 'bg-white text-black' : 'text-white',
        ]"
        @click="router.push('/dashboard')"
      >
        <v-icon name="ri-dashboard-line" fill="black" scale="1.6" />
        <p class="text-base font-medium">Dashboard</p>
      </div>

      <div
        :class="[
          'flex items-center gap-2 px-4 py-2 rounded-md cursor-pointer',
          isActive('/tasks').value ? 'bg-white text-black' : 'text-white',
        ]"
        @click="router.push('/tasks')"
      >
        <v-icon name="fa-tasks" fill="black" scale="1.6" />
        <p class="text-base font-medium">My Task</p>
      </div>

      <div
        :class="[
          'flex items-center gap-2 px-4 py-2 rounded-md cursor-pointer',
          isActive('/categories').value ? 'bg-white text-black' : 'text-white',
        ]"
        @click="router.push('/categories')"
      >
        <v-icon name="fa-layer-group" fill="black" scale="1.6" />
        <p class="text-base font-medium">Categories</p>
      </div>

      <div
        :class="[
          'flex items-center gap-2 px-4 py-2 rounded-md cursor-pointer',
          isActive('/profile').value ? 'bg-white text-black' : 'text-white',
        ]"
        @click="router.push('/profile')"
      >
        <v-icon name="fa-user-alt" fill="black" scale="1.6" />
        <p class="text-base font-medium">Profile</p>
      </div>

     
    </div>

    <!-- Logout -->
    <div
      class="flex items-center justify-center gap-4 bg-opacity-20 bg-white px-2 py-2 rounded-2xl cursor-pointer hover:bg-opacity-40 w-full"
      @click="logout"
    >
      <v-icon name="md-logout" fill="red" scale="1.6" />
      <p class="text-base font-medium text-red-700">Log out</p>
    </div>
  </div>
</template>
