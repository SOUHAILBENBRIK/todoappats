<script setup>
import { useRouter } from 'vue-router'
import dashboardIcon from '../assets/icons/dashboard.svg'
import logoutIcon from '../assets/icons/logout.svg'
import tasksIcon from '../assets/icons/tasks.svg'
import helpIcon from '../assets/icons/help.svg'
import categoryIcon from '../assets/icons/category.svg'
import setingIcon from '../assets/icons/settings.svg'
import userIcon from '../assets/icons/user.svg'
import { onMounted, ref } from 'vue'
import { getUser } from '@/api/userApi'
const router = useRouter()
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
        userName.value = user.name
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
onMounted(() => {
  getUserInfo()
})
</script>

<template>
  <div class="bg-amber-400 h-[93vh] flex flex-col justify-between items-start gap-5 w-[12vw] p-4">
    <!-- Profile -->
    <div class="flex flex-col items-center gap-2 w-full">
      <img
        :src="profile ? `http://localhost:8000${profile}` : userIcon"
        alt="Profile"
        class="bg-white rounded-full h-20 w-20"
      />
      <p class="text-black text-sm font-semibold overflow-ellipsis">{{ userName }}</p>
      <p class="text-black text-sm font-semibold overflow-ellipsis">{{ email }}</p>
    </div>

    <!-- Sidebar Navigation -->
    <div class="flex flex-col gap-4 w-full">
      <div
        class="flex items-center gap-2 bg-white text-black px-4 py-2 rounded-md cursor-pointer"
        @click="router.push('/dashboard')"
      >
        <img :src="dashboardIcon" alt="Dashboard" class="h-6 w-6" />
        <p class="text-base font-medium">Dashboard</p>
      </div>

      <div
        class="flex items-center gap-2 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-white hover:text-black"
        @click="router.push('/tasks')"
      >
        <img :src="tasksIcon" alt="Tasks" class="h-6 w-6" />
        <p class="text-base font-medium">My Task</p>
      </div>

      <div
        class="flex items-center gap-2 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-white hover:text-black"
        @click="router.push('/categories')"
      >
        <img :src="categoryIcon" alt="Categories" class="h-6 w-6" />
        <p class="text-base font-medium">Categories</p>
      </div>

      <div
        class="flex items-center gap-2 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-white hover:text-black"
        @click="router.push('/profile')"
      >
        <img :src="setingIcon" alt="Settings" class="h-6 w-6" />
        <p class="text-base font-medium">Profile</p>
      </div>

      <div
        class="flex items-center gap-2 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-white hover:text-black"
        @click="router.push('/help')"
      >
        <img :src="helpIcon" alt="Help" class="h-6 w-6" />
        <p class="text-base font-medium">Help</p>
      </div>
    </div>

    <!-- Logout -->
    <div
      class="flex items-center justify-center gap-4 bg-opacity-20 bg-amber-500 px-2 py-2 rounded-2xl cursor-pointer hover:bg-opacity-40 w-full"
      @click="logout"
    >
      <img :src="logoutIcon" alt="Logout" class="h-6 w-6" />
      <p class="text-base font-medium text-white">Log out</p>
    </div>
  </div>
</template>
