<script setup lang="ts">
import emailIcon from '@/assets/icons/email.svg'
import passwordIcon from '@/assets/icons/password.svg'
import outlinepasswordIcon from '@/assets/icons/password-outline.svg'
import userIcon from '@/assets/icons/user.svg'
import picture from '@/assets/images/register.svg'
import { ref, reactive, watch } from 'vue'
import { type UserRegistration, registerUser } from '@/api/authApi'
import InputComponent from '@/components/InputComponent.vue'
import router from '@/router'
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
watch(age, (newAge) => {
  if (isNaN(Number(newAge))) {
    errors.age = 'Age must be a number'
  } else {
    errors.age = ''
  }
})
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
watch(repassword, (newRepassword) => {
  if (newRepassword !== password.value) {
    errors.repassword = 'Passwords do not match'
  } else {
    errors.repassword = ''
  }
})
watch(userName, (newUserName) => {
  if (newUserName.length < 4) {
    errors.userName = 'Username must be at least 4 characters long'
  } else {
    errors.userName = ''
  }
})
watch(name, (newName) => {
  if (newName.length < 4) {
    errors.name = 'Name must be at least 4 characters long'
  } else {
    errors.name = ''
  }
})
watch(lastName, (newLastName) => {
  if (newLastName.length < 4) {
    errors.lastName = 'Last name must be at least 4 characters long'
  } else {
    errors.lastName = ''
  }
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
  if (password.value !== repassword.value) {
    errors.repassword = 'Passwords do not match'
    return
  }
  if (Object.values(errors).some((error) => error)) {
    return
  }
  if (
    email.value === '' ||
    password.value === '' ||
    userName.value === '' ||
    name.value === '' ||
    lastName.value === '' ||
    age.value === ''
  ) {
    errors.email = 'Please fill all the fields'
    errors.password = 'Please fill all the fields'
    errors.userName = 'Please fill all the fields'
    errors.name = 'Please fill all the fields'
    errors.lastName = 'Please fill all the fields'
    errors.age = 'Please fill all the fields'

    return
  }
  loading.value = true
  registerUser(user).then((response) => {
    if (response.status === 201) {
      router.push({ name: 'home' })
    }
  })
}
</script>
<template>
  <main v-if="!loading">
    <div class="container">
      <div class="picture">
        <img :src="picture" alt="picture" />
      </div>
      <div class="form">
        <h1 class="title">Sign Up</h1>
        <InputComponent placeHolder="Enter your name" :iconPath="userIcon" v-model="name" />
        <p class="error" v-if="errors.name">{{ errors.name }}</p>
        <InputComponent
          placeHolder="Enter your last name"
          :iconPath="userIcon"
          v-model="lastName"
        />
        <p class="error" v-if="errors.lastName">{{ errors.lastName }}</p>
        <InputComponent
          placeHolder="Enter your user name"
          :iconPath="userIcon"
          v-model="userName"
        />
        <p class="error" v-if="errors.userName">{{ errors.userName }}</p>
        <InputComponent placeHolder="Enter your email" :iconPath="emailIcon" v-model="email" />
        <p class="error" v-if="errors.email">{{ errors.email }}</p>
        <InputComponent placeHolder="Enter your age" :iconPath="userIcon" v-model="age" />
        <p class="error" v-if="errors.age">{{ errors.age }}</p>
        <InputComponent
          placeHolder="Enter your password"
          :iconPath="passwordIcon"
          v-model="password"
        />
        <p class="error" v-if="errors.password">{{ errors.password }}</p>
        <InputComponent
          placeHolder="Renter your password"
          :iconPath="outlinepasswordIcon"
          v-model="repassword"
        />
        <p class="error" v-if="errors.repassword">{{ errors.repassword }}</p>
        <div class="checkbox">
          <input type="checkbox" id="terms" name="terms" value="terms" v-model="checkBox" />
          <label for="terms">I accept the terms and conditions</label>
        </div>
        <button @click="register" :disabled="!checkBox">Sign Up</button>
        <div class="login">
          <p>Have an account ?</p>
          <router-link to="/login">Login</router-link>
        </div>
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
button:disabled {
  background-color: #ff909060;
  cursor: not-allowed;
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
.login {
  display: flex;
  justify-content: center;
  gap: 10px;
  color: black;
  font-weight: 300;
  font-size: 1rem;
}
</style>
