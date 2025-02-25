<script setup lang="ts">
import { defineProps } from 'vue'
import { type Task } from '../entity/tasks.ts'
const props = defineProps<{
  task: Task
  onClick: () => void
}>()
</script>

<template>
  <div
    class="task bg-white p-2 rounded-lg w-full border border-gray-300 text-black flex flex-row gap-2 items-start cursor-pointer hover:bg-gray-200"
    @click="onClick"
  >
    <div class="task-dot h-4 w-4 rounded-full bg-white border-2 border-tomato"></div>
    <div class="task-details w-11/12">
      <div
        class="task-content flex flex-row gap-2 items-start justify-between p-2 w-full rounded-lg"
      >
        <div style="width: 65%; max-height: 150px">
          <p class="title text-xl font-bold text-black overflow-hidden">{{ task.title }}</p>
          <p class="description text-sm font-light text-black overflow-hidden">
            {{ task.description }}
          </p>
        </div>
        <img
          :src="`http://127.0.0.1:8000${task.picture}`"
          alt="task image"
          v-if="task.picture != null"
          class="w-1/5 h-24 rounded-lg object-cover"
        />
      </div>
      <div
        class="task-footer flex flex-row gap-2 items-center justify-between p-2 w-full rounded-lg text-black"
      >
        <p>
          Priority : <span class="text-blue-500 font-bold">{{ task.priority }}</span>
        </p>
        <p>
          Status : <span class="text-red-500 font-bold">{{ task.status }}</span>
        </p>
        <p>
          createdAt : <span class="font-bold">{{ task.createdAt.split('T')[0] }}</span>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.task-dot {
  background-color: white;
  border: tomato 2px solid;
}
</style>
