<script setup lang="ts">
import { watch, ref, onMounted, computed } from 'vue'
import InputComponent from '@/components/InputComponent.vue'
import type { Priority } from '@/entity/priority'
import type { Status } from '@/entity/status'
import { getStatus } from '@/api/statusApi'
import { getPriority } from '@/api/priorityApi'
import { updateTask } from '@/api/taksApi'
import Loading from '@/components/Loading.vue'
import { useTaskHandling } from '@/stores/task'
import type { Task } from '@/entity/tasks'
const loading = ref(false)

const props = defineProps<{
  task: Task
}>()

const title = ref('')
const description = ref<string | undefined>('')
const priority = ref<Priority | null>(null)
const status = ref<Status | null>(null)
const deadline = ref<Date | null>(null)
const photo = ref<File | null>(null)
const openPriority = ref(false)
const openStatus = ref(false)
const priorityList = ref<Priority[]>([])
const statusList = ref<Status[]>([])
const imagePreview = ref<string | null>(null)
function openPriorityF() {
  openPriority.value = !openPriority.value
}
const formattedDeadline = computed({
  get() {
    return deadline.value ? deadline.value.toISOString().split('T')[0] : ''
  },
  set(value: string) {
    deadline.value = value ? new Date(value) : null
  }
})

function handleFileChange(event: Event) {
  const target = event.target as HTMLInputElement
  if (target.files && target.files.length > 0) {
    const file = target.files[0]
    photo.value = file
    imagePreview.value = URL.createObjectURL(file) 
  }
}
function openStatusF() {
  openStatus.value = !openStatus.value
}
function getAllStatus() {
  getStatus()
    .then((response) => {
      statusList.value = JSON.parse(response.data.data)
    })
    .catch((err) => {
      console.log('error', err)
    })
}

function getAllPriority() {
  getPriority()
    .then((response) => {
      priorityList.value = JSON.parse(response.data.data)
    })
    .catch((err) => {
      console.log('error', err)
    })
}
function changePriority(newPriority: Priority) {
  priority.value = newPriority
  openPriority.value = false
}
function changeStatus(newStatus: Status) {
  status.value = newStatus
  openStatus.value = false
}
function handleSubmit() {
    console.log(priority,status)
  if (priority.value != null && status.value != null) {
    loading.value = true
    const formData = new FormData()
    formData.append('title', title.value)
    formData.append('description', description.value || '')
    formData.append('priority', priority.value?.id.toString())
    formData.append('status', status.value?.id.toString())
    formData.append('deadline', deadline.value ? deadline.value.toString() : '')
    if (photo.value) {
    formData.append('picture', photo.value)
  }
    updateTask(props.task.id, formData)
      .then((response) => {
        if (response.status === 200) {
          useTaskHandling().changeEditTask(false)
          loading.value = false
        } else {
          console.log('response', response)
          loading.value = false
        }
      })
      .catch((err) => {
        loading.value = false
        console.log('error', err.message)
      })
  } else {
    console.log('Please fill all the fields')
  }
}
function goBack() {
  useTaskHandling().changeEditTask(false)
}
onMounted(() => {
  if (props.task.picture) {
    imagePreview.value = `http://localhost:8000${props.task.picture}`
  }
    title.value = props.task.title
    description.value = props.task.description ? props.task.description : ''
    console.log(props.task.deadline)
    
    deadline.value =  props.task.deadline? new Date(props.task.deadline) : null
    console.log(deadline.value)
    priority.value = props.task.priority
    status.value = props.task.status
  getAllPriority()
  getAllStatus()
})
</script>

<template>
  <Loading v-if="loading" />
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-center justify-center border rounded-2xl px-10 gap-20"
    v-else
  >
    <div class="w-full flex flex-row items-center justify-between gap-5">
      <p class="text-2xl text-black">Add Task</p>
      <div class="flex gap-4 cursor-pointer" @click="goBack">
        <v-icon name="fa-arrow-alt-circle-left" fill="black" scale="1.5" />
        <p class="underline text-black">Go back</p>
      </div>
    </div>
    <div class="w-full flex flex-col gap-5 border-1 border-gray-400 p-5 rounded-2xl justify-center items-center">
      <label
        class="w-30 h-30 border-dashed border-2 border-gray-500 rounded-2xl flex items-center justify-center cursor-pointer"
      >
        <input type="file" class="hidden" @change="handleFileChange" />
        <img
          v-if="imagePreview"
          :src="imagePreview"
          alt="Uploaded Image"
          class="w-full h-full object-cover"
        />
        <span v-else class="text-gray-500">Upload Image</span>
      </label>
      <InputComponent placeHolder="Enter task title" iconPath="fc-parallel-tasks" v-model="title" />
      <InputComponent
        placeHolder="Enter task description"
        iconPath="fc-generic-sorting-desc"
        v-model="description"
      />
      <button
        class="w-full flex felx-row justify-between items-center bg-blue-600 py-3 px-15 rounded-2xl text-start text-white"
        @click="openPriorityF"
      >
        <p>{{ priority ? 'Priority : ' + priority.name : 'Select Priority' }}</p>
        <v-icon
          :name="!openPriority ? 'fa-arrow-alt-circle-down' : 'fa-arrow-alt-circle-up'"
          fill="white"
          scale="2"
          class="cursor-pointer"
        />
      </button>
      <div
        v-if="openPriority && priorityList.length != 0"
        v-for="item in priorityList"
        :key="item.id"
        class="w-full bg-white py-3 px-15 rounded-2xl text-start text-black border-1 border-gray-300"
      >
        <p class="cursor-pointer" @click="changePriority(item)">{{ item.name }}</p>
      </div>
      <div v-else-if="openPriority && priorityList.length == 0">
        <p class="text-red-500">No priority available</p>
      </div>
      <button
        class="w-full flex felx-row justify-between items-center bg-blue-600 py-3 px-15 rounded-2xl text-start text-white"
        @click="openStatusF"
      >
        <p>{{ status ? 'Status : ' + status.name : 'Select Status' }}</p>
        <v-icon
          :name="!openPriority ? 'fa-arrow-alt-circle-down' : 'fa-arrow-alt-circle-up'"
          fill="white"
          scale="2"
          class="cursor-pointer"
        />
      </button>
      <div
        v-if="openStatus && statusList.length != 0"
        v-for="item in statusList"
        :key="item.id"
        class="w-full bg-white py-3 px-15 rounded-2xl text-start text-black border-1 border-gray-300"
      >
        <p class="cursor-pointer" @click="changeStatus(item)">{{ item.name }}</p>
      </div>
      <div v-else-if="openStatus && statusList.length == 0"></div>
      <input
        type="date"
        v-model="formattedDeadline"
        class="w-full px-15 py-3 rounded-xl focus:border-gray-300 text-black border-gray-500 border-1"
      />
    </div>

    <button
      class="bg-white p-5 w-full rounded-2xl text-black border-1 border-gray-500 cursor-pointer"
      @click="handleSubmit"
    >
      Edit Task
    </button>
  </div>
</template>
