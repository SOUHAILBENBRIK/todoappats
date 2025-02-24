<script setup lang="ts">
import userIcon from '@/assets/icons/user.svg'
import emailIcon from '@/assets/icons/email.svg'
import passwordIcon from '@/assets/icons/password.svg'
import InputComponent from '@/components/InputComponent.vue'
import { reactive, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
const email = ref('')
const password = ref('')
const userName = ref('')
const name = ref('')
const lastName = ref('')
const age = ref('')

const errors = reactive<Record<string, string>>({})

const router = useRouter()

watch(age, (newAge) => {
  errors.age = isNaN(Number(newAge)) ? 'Age must be a number' : ''
})
watch(email, (newEmail) => {
  errors.email = !newEmail.includes('@') ? 'Email must contain @' : ''
})
watch(password, (newPassword) => {
  errors.password = newPassword.length < 8 ? 'Password must be at least 8 characters long' : ''
})
watch(userName, (newUserName) => {
  errors.userName = newUserName.length < 4 ? 'Username must be at least 4 characters long' : ''
})
watch(name, (newName) => {
  errors.name = newName.length < 4 ? 'Name must be at least 4 characters long' : ''
})
watch(lastName, (newLastName) => {
  errors.lastName = newLastName.length < 4 ? 'Last name must be at least 4 characters long' : ''
})
</script>

<template>
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-start justify-start border border-black rounded-2xl px-10"
  >
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-8">
      <p class="text-amber-500 text-2xl">Account Information</p>
      <p class="text-black underline cursor-pointer" @click="router.push('/dashboard')">Go Back</p>
    </div>
    <div
      class="w-full flex flex-row items-center justify-start gap-5 py-3 px-5 bg-amber-300 rounded-3xl"
    >
      <img :src="userIcon" alt="user icon" class="w-20 h-20 bg-gray-200 rounded-full p-2" />
      <div class="flex flex-col gap-2">
        <p class="text-2xl text-black font-bold">Souhail ben brik</p>
        <p class="text-l text-gray-800">benbriksouhail43@gmail.com</p>
      </div>
    </div>
    <div class="w-full flex flex-col items-start justify-start gap-5 py-5">
      <InputComponent placeHolder="Enter your name" :iconPath="userIcon" v-model="name" />
      <p class="text-red-500 text-sm" v-if="errors.name">{{ errors.name }}</p>
      <InputComponent placeHolder="Enter your last name" :iconPath="userIcon" v-model="lastName" />
      <p class="text-red-500 text-sm" v-if="errors.lastName">{{ errors.lastName }}</p>
      <InputComponent placeHolder="Enter your user name" :iconPath="userIcon" v-model="userName" />
      <p class="text-red-500 text-sm" v-if="errors.userName">{{ errors.userName }}</p>
      <InputComponent placeHolder="Enter your email" :iconPath="emailIcon" v-model="email" />
      <p class="text-red-500 text-sm" v-if="errors.email">{{ errors.email }}</p>
      <InputComponent placeHolder="Enter your age" :iconPath="userIcon" v-model="age" />
      <p class="text-red-500 text-sm" v-if="errors.age">{{ errors.age }}</p>
      <InputComponent
        placeHolder="Enter your password"
        :iconPath="passwordIcon"
        v-model="password"
      />
      <p class="text-red-500 text-sm" v-if="errors.password">{{ errors.password }}</p>
    </div>
    <div class="w-full flex flex-row justify-center gap-5 py-6">
      <button class="w-[65%] text-black bg-amber-400 rounded-3xl py-4">Update Info</button>
    </div>
  </div>
</template>
