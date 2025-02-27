<script setup lang="ts">
import type { Task } from '@/entity/tasks'
import completedIcon from '../assets/icons/Book.svg'
import TaskItem from './TaskItem.vue'
import { onMounted, ref } from 'vue'
import { getCompletedTasks } from '@/api/taksApi'
const date = new Date().toDateString().split(' ').slice(1).join(' ')
const tasks = ref<Task[]>([])

function getAllTasks() {
  getCompletedTasks()
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
      console.log('error', err.message)
    })
}

onMounted(() => {
  getAllTasks()
})
</script>

<template>
  <div
    class="bg-gray-100 flex flex-col justify-between items-start gap-5 w-full shadow-lg h-1/2 p-2.5"
  >
    <div class="flex flex-row gap-2.5 items-center">
      <img :src="completedIcon" alt="completed image" />
      <p class="text-black">Completed Task</p>
    </div>
    <div class="flex flex-col gap-2.5 p-5 w-full h-5/6 overflow-y-auto">
      <div v-if="tasks.length === 0" class="text-center">
        <p class="text-black text-2xl">No completed tasks</p>
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
