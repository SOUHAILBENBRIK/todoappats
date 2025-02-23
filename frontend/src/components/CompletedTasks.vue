<script setup lang="ts">
import type { Task } from '@/entity/tasks'
import completedIcon from '../assets/icons/Book.svg'
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
  <div
    class="bg-gray-100 flex flex-col justify-between items-start gap-5 w-full shadow-lg h-1/2 p-2.5"
  >
    <div class="flex flex-row gap-2.5 items-center">
      <img :src="completedIcon" alt="completed image" />
      <p class="text-black">Completed Task</p>
    </div>
    <div class="flex flex-col gap-2.5 p-5 w-full h-5/6 overflow-y-auto">
      <div v-if="tasks.length === 0">
        <p>No tasks available</p>
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
