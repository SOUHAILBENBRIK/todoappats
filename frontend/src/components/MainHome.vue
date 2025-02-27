<script setup lang="ts">
import TodoList from './TodoList.vue'
import TaskStatus from './TasksStatus.vue'
import CompletedTasks from './CompletedTasks.vue'
import AddTask from './AddTask.vue'
import { ref, inject } from 'vue'
import { useTaskHandling } from '@/stores/task'

</script>

<template>
  <AddTask v-if="useTaskHandling().isNewTask" />
  <div class="h-full w-full pt-10 bg-white flex flex-col justify-start items-center gap-5" v-else>
    <p class="text-2xl font-bold w-full text-black pl-7">Welcome Back , Souhail</p>
    <div
      class="flex flex-row gap-5 justify-start items-start p-5 border border-gray-300 border-opacity-30 h-[80vh] w-[80vw] rounded-lg"
    >
      <TodoList />
      <div class="w-1/2 h-full flex flex-col gap-5">
        <TaskStatus />
        <CompletedTasks />
      </div>
    </div>
  </div>
</template>
