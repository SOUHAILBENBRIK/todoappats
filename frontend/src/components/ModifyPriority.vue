<script setup lang="ts">
import taskIcon from '@/assets/icons/tasks.svg'
import type { Priority } from '@/entity/priority'
import { useRouter } from 'vue-router'
import { inject, reactive, ref, watch, type Ref } from 'vue'
import InputComponent from './InputComponent.vue'
import { createPriority, getPriority, type PriorityCreation } from '@/api/priorityApi'
const router = useRouter()
const title = ref('')
const level = ref('')
const loading = ref(false)
const errors = reactive<Record<string, string>>({})
watch(level, (newLevel) => {
  errors.level = isNaN(Number(newLevel)) ? 'Age must be a number' : ''
})
watch(title, (newTitle) => {
  errors.title = newTitle.length < 3 ? 'Priority name should be more then 3 character' : ''
})
const isNewPriority : Ref<boolean, boolean> = inject('isNewPriority', ref(true))

function addPriority() {
  if (errors.title || errors.level) {
    console.log('error')
    return
  } else {
    const priority: PriorityCreation = {
      name: title.value,
      level: Number(level.value),
    }
    createPriority(priority)
      .then((response) => {
        if (response.status === 200) {
          isNewPriority.value = false
        } else {
          console.log('response', response)
          loading.value = false
          title.value = ''
          level.value = ''
        }
      })
      .catch((err) => {
        console.log('error', err)
        loading.value = false
        title.value = ''
        level.value = ''
      })
  }
}
</script>

<template>
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-center justify-center border border-black rounded-2xl px-10 bg-amber-300"
  >
    <div class="w-2/3 p-5 bg-amber-400 rounded-2xl flex flex-col items-center justify-center gap-7">
      <p class="text-white text-2xl">Add Priority</p>
      <div class="flex flex-col items-start justify-start gap-5 w-full">
        <InputComponent placeHolder="Enter priority name" :iconPath="taskIcon" v-model="title" />
        <p class="text-red-500 text-sm text-start" v-if="errors.title">{{ errors.title }}</p>
      </div>
      <div class="flex flex-col items-start justify-start gap-5 w-full">
        <InputComponent placeHolder="Enter priority level" :iconPath="taskIcon" v-model="level" />
        <p class="text-red-500 text-sm text-start" v-if="errors.level">{{ errors.level }}</p>
      </div>

      <button class="w-2/3 p-4 bg-white rounded-2xl text-black" @click="addPriority">
        create priority
      </button>
    </div>
  </div>
</template>
