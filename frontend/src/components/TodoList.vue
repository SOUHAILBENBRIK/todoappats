<script setup lang="ts">
import type { Task } from '@/entity/tasks'
import paddingIcon from '../assets/icons/Pending.svg'
import addIcon from '../assets/icons/add.svg'

const date = new Date().toDateString().split(' ').slice(1).join(' ')
const tasks: Task[] = [
  {
    title: 'Task 1',
    description: 'This is the first task',
    createdAt: '2021-10-10T10:10:10.000Z',
    completed: false,
    id: 1,
    userId: null,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 2',
    description: 'This is the second task',
    createdAt: '2021-10-10T10:10:10.000Z',
    completed: false,
    id: 2,
    userId: null,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 3',
    description: 'This is the third task',
    createdAt: '2021-10-10T10:10:10.000Z',
    completed: false,
    id: 3,
    userId: null,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 4',
    description: 'This is the fourth task',
    createdAt: '2021-10-10T10:10:10.000Z',
    completed: false,
    id: 4,
    userId: null,
    completedAt: null,
    deadline: null,
  },
  {
    title: 'Task 5',
    description: 'This is the fifth task',
    createdAt: '2021-10-10T10:10:10.000Z',
    completed: false,
    id: 5,
    userId: null,
    completedAt: null,
    deadline: null,
  },
]
</script>

<template>
  <div class="todo-list">
    <div class="m-header">
      <div class="header">
        <img :src="paddingIcon" alt="padding image" />
        <p>To-Do</p>
      </div>
      <div class="header">
        <img :src="addIcon" alt="add icon" />
        <p>Add Task</p>
      </div>
    </div>
    <div class="date-div">
      <p>{{ date }}</p>
      <p style="color: blue">today</p>
    </div>
    <div class="tasks">
      <div v-if="tasks.length === 0">
        <p>No tasks available</p>
      </div>
      <div v-for="task in tasks" :key="task.id" class="task">
        <p>{{ task.title }}</p>
        <p>{{ task.description }}</p>
        <div class="task-footer">
          <p>createdAt : {{ task.createdAt.split('T')[0] }}</p>
          <p>Status : {{ task.completed ? 'Finished' : 'Padding' }}</p>
          <p>Priority : Normal</p>
        </div>
      </div>
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
  width: 50%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  height: 75vh;
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
.task {
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  width: 100%;
  border: black 1px solid;
  border-radius: 10px;
  color: black;
}
.task-footer {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  width: 100%;
  border-radius: 10px;
  color: black;
}
</style>
