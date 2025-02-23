<script setup lang="ts">
import type { Task } from '@/entity/tasks'
import paddingIcon from '../assets/icons/Pending.svg'
import addIcon from '../assets/icons/add.svg'
import TaskItem from './TaskItem.vue'
const date = new Date().toDateString().split(' ').slice(1).join(' ')
const tasks: Task[] = [
  {
    title: 'Task 1',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 1,
    user: 1,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 1',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 2,
    user: 1,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 1',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 3,
    user: 1,
    completedAt: null,
    deadline: null,
  },
]
</script>

<template>
  <div class=" bg-gray-100 flex flex-col justify-between items-start gap-5 w-1/2 shadow-lg h-full">
    <div class="flex flex-row gap-1 justify-between items-center p-2.5 w-full rounded-lg text-white">
      <div class="flex flex-row gap-2.5 items-center justify-start">
        <img :src="paddingIcon" alt="padding image" />
        <p class="text-black">To-Do</p>
      </div>
      <div class="flex flex-row gap-2.5 items-center justify-start">
        <img :src="addIcon" alt="add icon" />
        <p class="text-black">Add Task</p>
      </div>
    </div>
    <div class="flex flex-row gap-2.5 items-center justify-start pl-5">
      <p class="text-black">{{ date }}</p>
      <p class="text-blue-500">today</p>
    </div>
    <div class="flex flex-col gap-2.5 p-5 w-full h-5/6 overflow-y-auto">
      <div v-if="tasks.length === 0">
        <p>No tasks available</p>
      </div>
      <TaskItem v-for="task in tasks" :key="task.id" :task="task" :onClick="()=>console.log('hi')"/>
    </div>
  </div>
</template>