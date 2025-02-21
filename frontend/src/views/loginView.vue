<script setup lang="ts">
import emailIcon from '@/assets/icons/email.svg'
import passwordIcon from '@/assets/icons/password.svg'
import picture from '@/assets/images/login.svg'
import { ref, reactive, watch } from 'vue'
import { type UserLogin, loginUser } from '@/api/authApi'
import InputComponent from '@/components/InputComponent.vue'
import router from '@/router'
const email = ref('')
const password = ref('')
const checkBox = ref(false)
const loading = ref(false)
const errors = reactive<Record<string, string>>({})

watch(email, (newEmail) => {
  if (!newEmail.includes('@')) {
    errors.email = 'Email must contain @'
  } else {
    errors.email = ''
  }
})
watch(password, (newPassword) => {
  if (newPassword.length < 8) {
    errors.password = 'Password must be at least 8 characters long'
  } else {
    errors.password = ''
  }
})

function login() {
  const user: UserLogin = {
    email: email.value,
    password: password.value,
  }

  if (Object.values(errors).some((error) => error)) {
    return
  }
  if (email.value === '' || password.value === '') {
    errors.email = 'Please fill all the fields'
    errors.password = 'Please fill all the fields'

    return
  }
  loading.value = true
  loginUser(user).then((response) => {
    if (response.status === 201) {
      router.push({ name: 'home' })
    }
  })
}
</script>
<template>
  <main v-if="!loading">
    <div class="container">
      <div class="form">
        <h1 class="title">Sign Up</h1>

        <InputComponent placeHolder="Enter your email" :iconPath="emailIcon" v-model="email" />
        <p class="error" v-if="errors.email">{{ errors.email }}</p>

        <InputComponent
          placeHolder="Enter your password"
          :iconPath="passwordIcon"
          v-model="password"
          :isPassword="true"
        />
        <p class="error" v-if="errors.password">{{ errors.password }}</p>

        <div class="checkbox">
          <input type="checkbox" id="terms" name="terms" value="terms" v-model="checkBox" />
          <label for="terms">Remember Me</label>
        </div>
        <button @click="login">Log in</button>
        <div class="register">
          <p>Don't have account</p>
          <router-link to="/register">Create One</router-link>
        </div>
      </div>
      <div class="picture">
        <img :src="picture" alt="picture" />
      </div>
    </div>
  </main>
  <loading v-else message="waiting please" />
</template>
<style scoped>
.form {
  display: flex;
  flex-direction: column;
  gap: 20px;
  height: 100vh;
  align-items: start;
  justify-content: center;
}
.container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  gap: 20px;
}
.picture {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 50vw;
}
.title {
  font-size: 3rem;
  font-weight: 700;
  color: black;
}
button {
  background-color: #ff9090;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

label {
  color: black;
  font-weight: 300;
}
.checkbox {
  display: flex;
  justify-content: start;
  gap: 10px;
}
input {
  background-color: #ff9090;
  color: #ff9090;
}
.error {
  color: red;
  font-size: 0.8rem;
  font-weight: 300;
}
.register {
  display: flex;
  justify-content: center;
  gap: 10px;
  color: black;
  font-weight: 300;
  font-size: 1rem;
}
</style>
