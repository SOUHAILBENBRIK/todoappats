<script setup lang="ts">
import taskIcon from '@/assets/icons/tasks.svg'

import { useRouter } from 'vue-router'
import { inject, reactive, ref, watch, type Ref } from 'vue'
import InputComponent from './InputComponent.vue'
import { createStatus, type StatusCreation } from '@/api/statusApi'

const router = useRouter()
const title = ref('')
const loading = ref(false)
const errors = reactive<Record<string, string>>({})
import Loading from './Loading.vue'
watch(title, (newTitle) => {
  errors.title = newTitle.length < 3 ? 'Status name should be more then 3 character' : ''
})
const isNewStatus: Ref<boolean, boolean> = inject('isNewStatus', ref(true))

function cancel() {
  isNewStatus.value = false
}

function addStatus() {
  if (errors.title || errors.level) {
    console.log('error')
    return
  } else {
    const status: StatusCreation = {
      name: title.value,
    }
    loading.value = true
    createStatus(status)
      .then((response) => {
        if (response.status === 200) {
          isNewStatus.value = false
        } else {
          console.log('response', response)
          loading.value = false
          title.value = ''
        }
      })
      .catch((err) => {
        console.log('error', err)
        loading.value = false
        title.value = ''
      })
  }
}
</script>

<template>
  <Loading v-if="loading" />
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-center justify-center border border-black rounded-2xl px-10 bg-gray-400"
  >
    <div class="w-2/3 p-5 bg-gray-300 rounded-2xl flex flex-col items-center justify-center gap-7">
      <p class="text-white text-2xl">Add Status</p>
      <div class="flex flex-col items-start justify-start gap-5 w-full">
        <InputComponent placeHolder="Enter status name" iconPath="fa-tasks" v-model="title" />
        <p class="text-red-500 text-sm text-start" v-if="errors.title">{{ errors.title }}</p>
      </div>

      <div class="flex flex-row items-center justify-center w-full gap-5">
        <button class="w-1/3 p-4 bg-white rounded-2xl text-black" @click="addStatus">
          create priority
        </button>
        <button class="w-1/3 p-4 rounded-2xl text-white bg-red-500" @click="cancel">cancel</button>
      </div>
    </div>
  </div>
</template>
