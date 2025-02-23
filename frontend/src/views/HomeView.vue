<script setup lang="ts">
import SideBar from '@/components/SideBar.vue'
import NavBar from '../components/NavBar.vue'
import MainHome from '../components/MainHome.vue'
</script>
<template>
  <div>
    <NavBar />
    <div class="flex flex-row items-start justify-start w-full h-full">
      <div class="h-full w-full flex flex-row gap-5">
        <SideBar />

        <div class="w-full h-full pt-5">
          <RouterView />
        </div>
      </div>
    </div>
  </div>
</template>
