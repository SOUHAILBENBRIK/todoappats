<script setup lang="ts">
import { defineProps } from 'vue'
import { type Task } from '../entity/tasks.ts'
const props = defineProps<{
  task: Task
}>()
</script>

<template>
  <div class="task">
    <div class="task-dot"></div>
    <div class="task-details">
      <div class="task-content">
        <div style="width: 65%; max-height: 150px">
          <p class="title">{{ task.title }}</p>
          <p class="description">{{ task.description }}</p>
        </div>
        <img :src="task.picture" alt="task image" v-if="task.picture != null" />
      </div>
      <div class="task-footer">
        <p>
          Priority : <span style="color: #42ade2; font-weight: 700">{{ task.priority }}</span>
        </p>

        <p>
          Status : <span style="color: #f21e1e; font-weight: 700">{{ task.status }}</span>
        </p>
        <p>
          createdAt : <span style="font-weight: 700">{{ task.createdAt.split('T')[0] }}</span>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.task {
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  width: 100%;
  border: rgba(0, 0, 0, 0.2) 1px solid;
  border-radius: 10px;
  color: black;
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: start;
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

.task-dot {
  height: 15px;
  width: 15px;
  border-radius: 100%;
  background-color: white;
  border: tomato 2px solid;
}
img {
  width: 20%;
  height: 100px;
  border-radius: 10px;
  object-fit: cover;
}
.task-content {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: start;
  justify-content: space-between;
  padding: 10px;
  width: 100%;
  border-radius: 10px;
}
.task-details {
  width: 90%;
}
.title {
  font-size: 1.5rem;
  font-weight: 700;
  color: black;
  overflow: hidden;
}
.description {
  font-size: 0.8rem;
  font-weight: 300;
  color: black;
  overflow: hidden;
}
</style>
