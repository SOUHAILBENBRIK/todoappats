<script setup>
import dashboardIcon from '../assets/icons/dashboard.svg'
import logoutIcon from '../assets/icons/logout.svg'
import vitalTasksIcon from '../assets/icons/vital.svg'
import tasksIcon from '../assets/icons/tasks.svg'
import helpIcon from '../assets/icons/help.svg'
import categoryIcon from '../assets/icons/category.svg'
import setingIcon from '../assets/icons/settings.svg'
import userIcon from '../assets/icons/user.svg'
</script>

<template>
  <div class="sidebar">
    <div class="profile-container">
      <img :src="userIcon" alt="logo" class="profile" />
      <p>Souhail Ben Brik</p>
      <p>benbriksouhail43@gmail.com</p>
    </div>
    <div class="sidebar-header">
      <div class="elementD">
        <img :src="dashboardIcon" alt="dashboard icon" />
        <p>Dashboard</p>
      </div>
      <div class="element">
        <img :src="vitalTasksIcon" alt="vital icon" />
        <p>Vital Task</p>
      </div>
      <div class="element">
        <img :src="tasksIcon" alt="tasks icon" />
        <p>My Task</p>
      </div>
      <div class="element">
        <img :src="categoryIcon" alt="category icon" />
        <p>Task Categories</p>
      </div>
      <div class="element">
        <img :src="setingIcon" alt="settings icon" />
        <p>Settings</p>
      </div>
      <div class="element">
        <img :src="helpIcon" alt="help icon" />
        <p>Help</p>
      </div>
    </div>
    <div class="sidebar-footer">
      <img :src="logoutIcon" alt="logout icon" />
      <p>Log out</p>
    </div>
  </div>
</template>

<style scoped>
.sidebar {
  background-color: #ff6767;
  height: 92vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: start;
  gap: 20px;
  width: 12vw;
  position: fixed;
  margin-top: 8vh;
}
.sidebar-header {
  display: flex;
  flex-direction: column;
  gap: 20px;
  justify-content: start;
  align-items: start;
  width: 12vw;
  height: 92vh;
}
.element {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: start;
  justify-content: start;
  width: 40xp;
  padding: 10px 5px;
  width: 90%;
  border-radius: 8px;
  margin-left: 20px;
}
.elementD {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: start;
  justify-content: start;
  width: 40xp;
  padding: 10px 5px;
  width: 90%;
  border-radius: 8px;
  margin-left: 20px;
  background-color: white;
  color: black;
}
.element p {
  color: white;
  font-size: 1rem;
  font-weight: 500;
}
.element img {
  height: 30px;
  width: 30px;
}
.profile {
  background-color: white;
  border-radius: 100%;
  height: 80px;
  width: 80px;
}
.profile-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.profile-container p {
  font-size: 0.8rem;
  font-weight: 400;
  color: black;
}
.sidebar-footer {
  display: flex;
  flex-direction: row;
  gap: 10px;
  align-items: start;
  justify-content: center;
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
  border-radius: 8px;
  width: 90%;
  margin-left: 8px;
  margin-bottom: 20px;
  cursor: pointer;
}
</style>
