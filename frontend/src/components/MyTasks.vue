<script setup lang="ts">
import { type Task } from '@/entity/tasks'
import userIcons from '../assets/icons/user.svg'
import { onMounted, ref } from 'vue'
import TaskItem from './TaskItem.vue'
import { getTasks } from '@/api/taksApi'
import Loading from './Loading.vue'
const tasks = ref<Task[]>([])
const task = ref<Task | null>(null)
const loading = ref(true)

function getAllTasks() {
  getTasks()
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        tasks.value = JSON.parse(response.data.data)
        console.log(tasks)
        loading.value = false
      } else {
        console.log('response', response)
      }
    })
    .catch((err) => {
      console.log('error', err)
    })
}
function changeTask(val: Task) {
  task.value = val
}

onMounted(() => {
  getAllTasks()
})
</script>

<template>
  <Loading v-if="loading" />
  <div class="h-full w-full flex flex-row gap-5 justify-start items-start py-2 px-4" v-else>
    <!-- Scrollable Task List -->
    <div class="flex-1 h-[85vh] border border-black rounded-2xl p-5 flex flex-col">
      <p>My Tasks</p>
      <div class="flex-1 overflow-y-auto flex flex-col gap-2.5">
        <div v-if="tasks.length === 0">
          <p>No tasks available</p>
        </div>
        <TaskItem
          v-for="task in tasks"
          :key="task.id"
          :task="task"
          :onClick="() => changeTask(task)"
        />
      </div>
    </div>

    <!-- Second Div -->
    <div v-if="task == null" class="flex-1 h-[85vh] border border-black rounded-2xl p-4">
      <p class="text-black text-2xl">NO Task Selected</p>
    </div>
    <div class="flex-1 h-[85vh] border border-black rounded-2xl p-4" v-else>
      <div class="flex flex-row gap-5 items-center justify-start">
        <img
          :src="task.picture ? `http://localhost:8000${task.picture}` : userIcons"
          alt="picture"
          class="w-30 h-30 rounded-2xl"
        />
        <div>
          <p class="text-black text-xl font-bold">{{ task.title }}</p>
          <p class="text-black">
            Priority : <span class="text-red-400 font-bold">{{ task.priority.name }}</span>
          </p>
          <p class="text-black">
            Status : <span class="text-red-400 font-bold">{{ task.status.name }}</span>
          </p>
          <p class="text-gray-400">Created on : {{ task.createdAt.split('T')[0] }}</p>
        </div>
      </div>
      <div class="h-1/4 py-10 w-4/5">
        <p class="overflow-ellipsis text-black">Task Description : {{ task.description }}</p>
      </div>
      <p class="text-black py-2">
        Deadline : {{ task.deadline != null ? task.deadline : 'no deadline' }}
      </p>
      <div class="h-1/3"></div>
      <div class="flex flex-row gap-5 items-center justify-end">
        <button class="bg-white p-4 rounded-2xl w-20 cursor-pointer text-black border-1">
          Edit
        </button>
        <button class="bg-red-600 p-4 rounded-2xl w-20 cursor-pointer text-white">Delete</button>
      </div>
    </div>
  </div>
</template>
