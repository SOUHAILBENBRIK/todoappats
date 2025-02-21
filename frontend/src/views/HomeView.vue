<script setup lang="ts">
import SideBar from '@/components/SideBar.vue'
import NavBar from '../components/NavBar.vue'
import MainHome from '../components/MainHome.vue'
</script>
<template>
  <NavBar />
  <div class="container">
    <SideBar />
    <MainHome />
  </div>
</template>
<style scoped>
.container {
  display: flex;
  flex-direction: row;
  align-items: start;
  width: 100vw;
}
</style>
