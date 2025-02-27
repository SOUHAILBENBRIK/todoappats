<script setup lang="ts">
import userIcon from '@/assets/icons/user.svg'

import InputComponent from '@/components/InputComponent.vue'
import { onMounted, reactive, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import Loading from '@/components/Loading.vue'
const email = ref('')
const password = ref('')
const userName = ref('')
const name = ref('')
const lastName = ref('')
const age = ref('')
const repassword = ref('')
const profile = ref(null)
const loading = ref(true)
import { getUser, updateUser } from '@/api/userApi'
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
watch(repassword, (newRepassword) => {
  errors.repassword = newRepassword !== password.value ? 'Passwords do not match' : ''
})

function getUserInfo() {
  getUser()
    .then((response) => {
      if (response.status === 200) {
        const user = JSON.parse(response.data.data)
        console.log('user', user)
        name.value = user.name
        lastName.value = user.lastName
        userName.value = user.username
        email.value = user.email
        age.value = user.age.toString()
        profile.value = user.profileImage
        loading.value = false
      } else {
        console.log('response', response)
        loading.value = false
      }
    })
    .catch((err) => {
      console.log('error', err)
      loading.value = false
    })
}
function updateUserInfo() {
  if (Object.values(errors).some((error) => error)) {
    errors.email = email.value ? '' : 'Please fill all the fields'
    errors.password = password.value ? '' : 'Please fill all the fields'
    errors.userName = userName.value ? '' : 'Please fill all the fields'
    errors.name = name.value ? '' : 'Please fill all the fields'
    errors.lastName = lastName.value ? '' : 'Please fill all the fields'
    errors.age = age.value ? '' : 'Please fill all the fields'
    errors.repassword = repassword.value ? '' : 'Please fill all the fields'
    return
  }
  const user = {
    name: name.value,
    lastName: lastName.value,
    username: userName.value,
    email: email.value,
    age: Number(age.value),
    password: password.value,
  }
  updateUser(user)
    .then((response) => {
      if (response.status === 200) {
        router.push('/dashboard')
      } else {
        console.log('response', response)
      }
    })
    .catch((err) => {
      console.log('error', err.message)
    })
}
onMounted(() => {
  getUserInfo()
})
</script>

<template>
  <Loading v-if="loading" />
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-start justify-start border border-black rounded-2xl px-10"
  >
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-8">
      <p class="text-black text-2xl">Account Information</p>
      <p class="text-black underline cursor-pointer" @click="router.push('/dashboard')">Go Back</p>
    </div>
    <div
      class="w-full flex flex-row items-center justify-start gap-5 py-3 px-5 bg-gray-700 rounded-3xl"
    >
      <img
        :src="profile ? `http://localhost:8000${profile}` : userIcon"
        alt="user icon"
        class="w-20 h-20 bg-gray-200 rounded-full p-2"
      />
      <div class="flex flex-col gap-2">
        <p class="text-2xl text-black font-bold">{{ name + ' ' + lastName }}</p>
        <p class="text-l text-gray-800">{{ email }}</p>
      </div>
    </div>
    <div class="w-full flex flex-col items-start justify-start gap-5 py-5">
      <InputComponent placeHolder="Enter your name" iconPath="fa-user-alt" v-model="name" />
      <p class="text-red-500 text-sm" v-if="errors.name">{{ errors.name }}</p>
      <InputComponent
        placeHolder="Enter your last name"
        iconPath="fa-user-alt"
        v-model="lastName"
      />
      <p class="text-red-500 text-sm" v-if="errors.lastName">{{ errors.lastName }}</p>
      <InputComponent
        placeHolder="Enter your user name"
        iconPath="fa-user-alt"
        v-model="userName"
      />
      <p class="text-red-500 text-sm" v-if="errors.userName">{{ errors.userName }}</p>
      <InputComponent
        placeHolder="Enter your email"
        iconPath="md-email"
        v-model="email"
        :readonly="true"
      />
      <p class="text-red-500 text-sm" v-if="errors.email">{{ errors.email }}</p>
      <InputComponent placeHolder="Enter your age" iconPath="fa-user-friends" v-model="age" />
      <p class="text-red-500 text-sm" v-if="errors.age">{{ errors.age }}</p>
      <InputComponent
        placeHolder="Enter your new password"
        iconPath="ri-lock-password-fill"
        v-model="password"
      />
      <p class="text-red-500 text-sm" v-if="errors.password">{{ errors.password }}</p>
      <InputComponent
        placeHolder="Renter your  password"
        iconPath="ri-lock-password-line"
        v-model="repassword"
      />
      <p class="text-red-500 text-sm" v-if="errors.repassword">{{ errors.repassword }}</p>
    </div>
    <div class="w-full flex flex-row justify-center gap-5 py-6">
      <button class="w-[65%] text-black bg-gray-700 rounded-3xl py-4" @click="updateUserInfo">
        Update Info
      </button>
    </div>
  </div>
</template>
