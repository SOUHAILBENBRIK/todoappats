<script setup lang="ts">
import searchIcon from '../assets/icons/Search.svg'
import notificationIcon from '../assets/icons/notification.svg'
import calanderIcon from '../assets/icons/calander.svg'
const date = new Date().toISOString().split('T')[0]
</script>
<template>
  <div class="nav-bar">
    <!--this is the title div-->
    <div>
      <p class="title">Dash<span class="titleSpan">Board</span></p>
    </div>
    <!--this is the search div-->
    <div>
      <input type="text" placeholder="Search" class="search-input" />
      <button class="search-button"><img :src="searchIcon" alt="searhIcon" /></button>
    </div>
    <!-- calander and notification button div div-->
    <div style="display: flex; flex-direction: row; align-items: center; gap: 5px">
      <button class="nc-button"><img :src="notificationIcon" alt="notification" /></button>
      <button class="nc-button"><img :src="calanderIcon" alt="calanderIcon" /></button>
    </div>
    <!-- this is the date div-->
    <div
      style="display: flex; flex-direction: column; align-items: center; justify-content: center"
    >
      <p class="date-title">Date</p>
      <p class="date-v">{{ date }}</p>
    </div>
  </div>
</template>

<style scoped>
.nav-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f8f8f8;
  width: 100vw;
  height: 8vh;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  padding: 5px 10px;
  position: fixed;
}
.title {
  font-size: 2rem;
  font-weight: 700;
  color: black;
  margin-left: 20px;
}
.titleSpan {
  font-size: 2rem;
  font-weight: 700;
  color: #ff9090;
}
.search-input {
  border: none;
  width: 35vw;
  height: 45px;
  color: black;
  background-color: white;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px 0 0 5px;
}
.search-button {
  background-color: #ff9090;
  color: white;
  height: 40px;
  border: none;
  cursor: pointer;
  border-radius: 0 5px 5px 0;
  padding: 10px;
}
.nc-button {
  background-color: #ff9090;
  color: white;
  height: 45px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  padding: 10px;
}
.date-title {
  font-size: 1rem;
  font-weight: normal;
  color: black;
}
.date-v {
  font-size: 0.8rem;
  font-weight: normal;
  color: #3abeff;
}
</style>
