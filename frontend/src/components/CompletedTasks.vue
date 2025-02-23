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
  <div class="todo-list">
    <div class="header">
      <img :src="completedIcon" alt="completed image" />
      <p>Completed Task</p>
    </div>

    
    <div class="tasks">
      <div v-if="tasks.length === 0">
        <p>No tasks available</p>
      </div>
      <TaskItem v-for="task in tasks" :key="task.id" :task="task" />
    </div>
  </div>
</template>

<style scoped>
.todo-list {
  background-color: #f5f5f5;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: start;
  gap: 20px;
  width: 100%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  height: 50%;
  padding: 10px 10px;
}
.header {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: center;
  justify-content: start;
}
.date-div {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: center;
  justify-content: start;
  padding-left: 20px;
}
.date-div p {
  color: black;
}
.header p {
  color: black;
}
.m-header {
  display: flex;
  flex-direction: row;
  gap: 20px;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  width: 100%;
  border-radius: 10px;
  color: white;
}
.tasks {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 20px;
  width: 100%;
  height: 85%;
  overflow-y: auto;
}
</style>
