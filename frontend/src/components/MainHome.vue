<script setup lang="ts">
import TodoList from './TodoList.vue';
import TaskStatus from './TasksStatus.vue';
import CompletedTasks from './CompletedTasks.vue';
</script>
<template>
  <div class="main-home">
    <p class="title">Welcome Back , Souhail</p>
    <div class="main-content">
      <TodoList />
      <div style="width: 50%; height: 100%; display: flex; flex-direction: column; gap: 20px">
        <TaskStatus />
        <CompletedTasks />
      </div>
    </div>
  </div>
</template>

<style scoped>
.main-home {
  height: 92vh;
  width: 88vw;
  margin-left: 12vw;
  margin-top: 8vh;
  padding-top: 5px;
  background-color: white;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
  gap: 20px;
}
.title {
  font-size: 2rem;
  font-weight: 700;
  width: 100%;
  color: black;
  padding-left: 30px;
}
.main-content {
  display: flex;
  flex-direction: row;
  gap: 20px;
  justify-content: start;
  align-items: start;
  padding: 20px;
  border: rgba(180, 180, 180, 0.3) 1px solid;
  height: 80vh;
  width: 80vw;
  border-radius: 10px;
}
</style>
