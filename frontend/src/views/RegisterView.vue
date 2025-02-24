<script setup lang="ts">
import emailIcon from '@/assets/icons/email.svg'
import passwordIcon from '@/assets/icons/password.svg'
import outlinepasswordIcon from '@/assets/icons/password-outline.svg'
import userIcon from '@/assets/icons/user.svg'
import picture from '@/assets/images/register.svg'
import { ref, reactive, watch } from 'vue'
import { type UserRegistration, registerUser } from '@/api/authApi'
import InputComponent from '@/components/InputComponent.vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const userName = ref('')
const name = ref('')
const checkBox = ref(true)
const lastName = ref('')
const age = ref('')
const repassword = ref('')
const loading = ref(false)
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
watch(repassword, (newRepassword) => {
  errors.repassword = newRepassword !== password.value ? 'Passwords do not match' : ''
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

function register() {
  const user: UserRegistration = {
    email: email.value,
    password: password.value,
    userName: userName.value,
    name: name.value,
    lastName: lastName.value,
    age: Number(age.value),
  }
  if (password.value !== repassword.value || Object.values(errors).some((error) => error)) {
    return
  }
  if (
    !email.value ||
    !password.value ||
    !userName.value ||
    !name.value ||
    !lastName.value ||
    !age.value
  ) {
    errors.email =
      errors.password =
      errors.userName =
      errors.name =
      errors.lastName =
      errors.age =
        'Please fill all the fields'
    return
  }
  loading.value = true
  registerUser(user).then((response) => {
    if (response.status === 201) {
      console.log('response', response.data)
      localStorage.setItem('token', response.data.token)
      router.push('/dashboard')
    }
  })
}
</script>

<template>
  <main v-if="!loading" class="flex flex-col items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row gap-8 items-center w-full max-w-4xl">
      <div class="hidden md:flex justify-center items-center w-1/2">
        <img :src="picture" alt="Register" class="max-w-full" />
      </div>
      <div class="flex flex-col gap-4 w-full md:w-1/2 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-900">Sign Up</h1>
        <InputComponent placeHolder="Enter your name" :iconPath="userIcon" v-model="name" />
        <p class="text-red-500 text-sm" v-if="errors.name">{{ errors.name }}</p>
        <InputComponent
          placeHolder="Enter your last name"
          :iconPath="userIcon"
          v-model="lastName"
        />
        <p class="text-red-500 text-sm" v-if="errors.lastName">{{ errors.lastName }}</p>
        <InputComponent
          placeHolder="Enter your user name"
          :iconPath="userIcon"
          v-model="userName"
        />
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
        <InputComponent
          placeHolder="Renter your password"
          :iconPath="outlinepasswordIcon"
          v-model="repassword"
        />
        <p class="text-red-500 text-sm" v-if="errors.repassword">{{ errors.repassword }}</p>
        <div class="flex items-center gap-2">
          <input
            type="checkbox"
            id="terms"
            v-model="checkBox"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded"
          />
          <label for="terms" class="text-gray-600 text-sm">I accept the terms and conditions</label>
        </div>
        <button
          @click="register"
          :disabled="!checkBox"
          class="bg-red-500 text-white py-2 px-4 rounded w-full disabled:bg-red-300"
        >
          Sign Up
        </button>
        <div class="flex justify-center gap-2 text-gray-600 text-sm">
          <p>Have an account?</p>
          <router-link to="/login" class="text-blue-500">Login</router-link>
        </div>
      </div>
    </div>
  </main>
  <loading v-else message="waiting please" />
</template>
