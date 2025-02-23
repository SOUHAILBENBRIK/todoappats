<script setup lang="ts">
import { type Task } from '@/entity/tasks'
import userIcons from '../assets/icons/user.svg'
import { ref } from 'vue'
import TaskItem from './TaskItem.vue'
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
    title: 'Task 2',
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
    title: 'Task 3',
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
  {
    title: 'Task 4',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 4,
    user: 1,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 5',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 5,
    user: 1,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 6',
    description:
      'This is the first task gfgfg fgkf lmdgml fdglfdg gfdgfdgk fdmlgkfdml gkd fmlgkd flmgkfdlmg kfd lmk gfdmlgk fdlgkfmldgk fdmlgk fdlmgk',
    createdAt: '2021-10-10T10:10:10.000Z',
    status: 1,
    priority: 1,
    picture:
      'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFUAfyVe3Easiycyh3isP9wDQTYuSmGPsPQvLIJdEYvQ_DsFq5Ez2Nh_QjiS3oZ3B8ZPfK9cZQyIStmQMV1lDPLw',
    id: 6,
    user: 1,
    completedAt: null,
    deadline: null,
  },
]
const task = ref(tasks[0])

function changeTask(val: Task) {
  task.value = val
  console.log(task.value)
}
</script>

<template>
  <div class="h-full w-full flex flex-row gap-5 justify-start items-start py-2 px-4">
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
    <div class="flex-1 h-[85vh] border border-black rounded-2xl p-4">
      <div class="flex flex-row gap-5 items-center justify-start">
        <img
          :src="task.picture != null ? task.picture : userIcons"
          alt="picture"
          class="w-30 h-30 rounded-2xl"
        />
        <div>
          <p class="text-black text-xl font-bold">{{ task.title }}</p>
          <p class="text-black">
            Priority : <span class="text-red-400 font-bold">{{ task.priority }}</span>
          </p>
          <p class="text-black">
            Status : <span class="text-red-400 font-bold">{{ task.status }}</span>
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
