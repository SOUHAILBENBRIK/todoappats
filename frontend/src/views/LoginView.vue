<script setup lang="ts">
import emailIcon from '@/assets/icons/email.svg'
import passwordIcon from '@/assets/icons/password.svg'
import picture from '@/assets/images/login.svg'
import { ref, reactive, watch, provide } from 'vue'
import { type UserLogin, loginUser } from '@/api/authApi'
import InputComponent from '@/components/InputComponent.vue'
import { useRouter } from 'vue-router'
import ErrorView from './ErrorView.vue'
import { useErroHandling } from '@/stores/general'
const email = ref('')
const password = ref('')
const checkBox = ref(false)
const loading = ref(false)
const errors = reactive<Record<string, string>>({})
const router = useRouter()

watch(email, (newEmail) => {
  errors.email = newEmail.includes('@') ? '' : 'Email must contain @'
})

watch(password, (newPassword) => {
  errors.password = newPassword.length >= 8 ? '' : 'Password must be at least 8 characters long'
})

function login() {
  if (Object.values(errors).some((error) => error) || !email.value || !password.value) {
    errors.email = email.value ? '' : 'Please fill all the fields'
    errors.password = password.value ? '' : 'Please fill all the fields'
    return
  }

  loading.value = true
  const user: UserLogin = { email: email.value, password: password.value }
  loginUser(user)
    .then((response) => {
      if (response.status === 200) {
        router.push('/dashboard')
        localStorage.setItem('token', response.data.token)
        router.push('/dashboard')
      } else {
        console.log('response', response)
        loading.value = false
        email.value = ''
        password.value = ''
        useErroHandling().changeError(true)
      }
    })
    .catch((err) => {
      //console.log('error', err)
      loading.value = false
      email.value = ''
      password.value = ''
      useErroHandling().changeError(true)
    })
}
</script>

<template>
  <ErrorView
    v-if="useErroHandling().error"
    error="Email or Password are incorect"
    statusCode="401"
    path="/login"
  />
  <main v-else-if="!loading" class="h-screen flex items-center justify-center bg-gray-100">
    <div class="flex flex-row items-center justify-center gap-10 p-8 bg-white shadow-md rounded-lg">
      <!-- Form Section -->
      <div class="flex flex-col gap-5 w-96">
        <h1 class="text-3xl font-bold text-gray-900">Sign In</h1>

        <InputComponent placeHolder="Enter your email" :iconPath="emailIcon" v-model="email" />
        <p class="text-red-500 text-sm" v-if="errors.email">{{ errors.email }}</p>

        <InputComponent
          placeHolder="Enter your password"
          :iconPath="passwordIcon"
          v-model="password"
          :isPassword="true"
        />
        <p class="text-red-500 text-sm" v-if="errors.password">{{ errors.password }}</p>

        <!-- Checkbox -->
        <div class="flex items-center gap-2">
          <input type="checkbox" id="terms" name="terms" v-model="checkBox" class="w-4 h-4" />
          <label for="terms" class="text-gray-700 text-sm">Remember Me</label>
        </div>

        <!-- Login Button -->
        <button
          @click="login"
          class="bg-red-400 text-white py-3 rounded-lg w-full hover:bg-red-500 transition"
        >
          Log in
        </button>

        <!-- Register Link -->
        <div class="flex justify-center gap-2 text-gray-700 text-sm">
          <p>Don't have an account?</p>
          <router-link to="/register" class="text-red-500 font-medium hover:underline">
            Create One
          </router-link>
        </div>
      </div>

      <!-- Image Section -->
      <div class="hidden md:flex w-1/2">
        <img :src="picture" alt="Login Illustration" class="object-cover w-full h-auto" />
      </div>
    </div>
  </main>

  <!-- Loading Component -->
  <loading v-else message="waiting please" />
</template>
