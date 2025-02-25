<script setup lang="ts">
import iconAdd from '@/assets/icons/add.svg'
import iconBlock from '@/assets/icons/block.svg'
import type { Priority } from '@/entity/priority'
import { type Status } from '@/entity/status'
import { useRouter } from 'vue-router'
const router = useRouter()
const status: Array<Status> = [
  {
    id: 1,
    name: 'Pending',
    user: null,
  },
  {
    id: 2,
    name: 'Not Started',
    user: null,
  },
  {
    id: 3,
    name: 'In Progress',
    user: null,
  },
]
const priority: Array<Priority> = [
  {
    id: 1,
    name: 'Low',
    user: null,
    level: 1,
  },
  {
    id: 2,
    name: 'Medium',
    user: null,
    level: 2,
  },
  {
    id: 3,
    name: 'High',
    user: null,
    level: 3,
  },
]
</script>

<template>
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-start justify-start border border-black rounded-2xl px-10"
  >
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-8">
      <p class="text-amber-400 text-2xl">Task Categories</p>
      <p class="text-black underline cursor-pointer" @click="router.push('/')">Go Back</p>
    </div>
    <div class="w-full py-10">
      <div class="w-full flex flex-row items-center justify-between">
        <p class="text-black">Task Status</p>
        <div class="flex flex-row items-center justify-between gap-5">
          <img :src="iconAdd" alt="icon add" class="h-5 w-5" />
          <p class="text-black">Add Task</p>
        </div>
      </div>
      <div class="overflow-x-auto py-2">
        <table class="min-w-full border border-gray-300 shadow-lg overflow-hidden">
          <thead>
            <tr class="bg-gray-300 rounded-t-lg">
              <th class="text-black px-4 py-2 border-r border-gray-400">Id</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Task Status</th>
              <th class="text-black px-4 py-2 border-gray-400">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in status"
              :key="item.id"
              class="text-black text-center px-4 py-2 bg-gray-100"
            >
              <td class="text-black border-r border-gray-400">{{ item.id }}</td>
              <td class="text-black border-r border-gray-400">{{ item.name }}</td>
              <td class="py-1 flex gap-2 items-center justify-center" v-if="item.user != null">
                <button class="bg-red-400 text-white w-16 py-1 rounded-md mx-5">Edit</button>
                <button class="bg-red-400 text-white w-16 py-1 rounded-md">Delete</button>
              </td>
              <td class="flex items-center justify-center py-2" v-else>
                <img :src="iconBlock" alt="block icon" class="h-5 w-5" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="w-full py-10">
      <div class="w-full flex flex-row items-center justify-between">
        <p class="text-black">Task Priority</p>
        <div class="flex flex-row items-center justify-between gap-5">
          <img :src="iconAdd" alt="icon add" class="h-5 w-5" />
          <p class="text-black">Add Task</p>
        </div>
      </div>
      <div class="overflow-x-auto py-2">
        <table class="min-w-full border border-gray-300 shadow-lg overflow-hidden">
          <thead>
            <tr class="bg-gray-300 rounded-t-lg">
              <th class="text-black px-4 py-2 border-r border-gray-400">Id</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Task Priority</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Priority Level</th>
              <th class="text-black px-4 py-2 border-gray-400">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in priority"
              :key="item.id"
              class="text-black text-center px-4 py-2 bg-gray-100"
            >
              <td class="text-black border-r border-gray-400">{{ item.id }}</td>
              <td class="text-black border-r border-gray-400">{{ item.name }}</td>
              <td class="text-black border-r border-gray-400">{{ item.level }}</td>
              <td class="py-1 flex gap-2 items-center justify-center" v-if="item.user != null">
                <button class="bg-red-400 text-white w-16 py-1 rounded-md mx-5">Edit</button>
                <button class="bg-red-400 text-white w-16 py-1 rounded-md">Delete</button>
              </td>
              <td class="flex items-center justify-center py-2" v-else>
                <img :src="iconBlock" alt="block icon" class="h-5 w-5" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
