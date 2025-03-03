<script setup lang="ts">
import type { Task } from '@/entity/tasks'
import paddingIcon from '../assets/icons/Pending.svg'
import addIcon from '../assets/icons/add.svg'
import TaskItem from './TaskItem.vue'
import { onMounted, provide, ref } from 'vue'
import { getTasks , deleteAllTasks} from '@/api/taksApi'
import { useTaskHandling } from '@/stores/task'
import AddTask from './AddTask.vue'
const date = new Date().toDateString().split(' ').slice(1).join(' ')
const tasks = ref<Task[]>([])

function getAllTasks() {
  getTasks()
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        console.log(response.data.data)
        tasks.value = JSON.parse(response.data.data)
        console.log(tasks)
      } else {
        console.log('response', response)
      }
    })
    .catch((err) => {
      console.log('error', err)
    })
}
function deleteAllF(){
  
  deleteAllTasks().then((response) => {
    if (response.status === 200) {
      console.log(response.data.data)
      tasks.value = []
      
    } else {
      console.log('response', response)
    }
  }).catch((err) => {
    console.log('error', err.message)
  })
}


onMounted(() => {
  getAllTasks()
})
</script>

<template>
  <AddTask v-if="useTaskHandling().isNewTask" />
  <div class="bg-gray-100 flex flex-col justify-between items-start gap-5 w-1/2 shadow-lg h-full" v-else>
    <div
      class="flex flex-row gap-1 justify-between items-center p-2.5 w-full rounded-lg text-white"
    >
      <div class="flex flex-row gap-2.5 items-center justify-start">
        <img :src="paddingIcon" alt="padding image" />
        <p class="text-black">To-Do</p>
      </div>
      <div
        class="flex flex-row gap-2.5 items-center justify-start cursor-pointer bg-red-500 p-2 rounded-lg"
        @click="deleteAllF"
      >
        <v-icon name="md-delete-sharp" fill="white" />
        <p class="text-black">Clear All Task</p>
      </div>
      <div
        class="flex flex-row gap-2.5 items-center justify-start cursor-pointer"
        @click="useTaskHandling().changeNewTask(true)"
      >
        <img :src="addIcon" alt="add icon" />
        <p class="text-black">Add Task</p>
      </div>
    </div>
    <div class="flex flex-row gap-2.5 items-center justify-start pl-5">
      <p class="text-black">{{ date }}</p>
      <p class="text-blue-500">today</p>
    </div>
    <div class="flex flex-col gap-2.5 p-5 w-full h-5/6 overflow-y-auto">
      <div v-if="tasks.length === 0" class="flex flex-col items-center justify-center gap-3 pt-30 cursor-pointer" @click="useTaskHandling().changeNewTask(true)">
        <p class="text-black">No tasks available</p>
        <p class="text-black">CLick Add Tasks to add new one</p>
        <img :src="addIcon" alt="add icon" class="w-15 h-15 bg-gray-200 rounded-3xl p-1" />
      </div>
      <TaskItem
        v-for="task in tasks"
        :key="task.id"
        :task="task"
        :onClick="() => console.log('')"
      />
    </div>
  </div>
</template>
