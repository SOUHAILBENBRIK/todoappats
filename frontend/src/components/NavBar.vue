<script setup lang="ts">
import searchIcon from '../assets/icons/Search.svg'
import notificationIcon from '../assets/icons/notification.svg'
import calanderIcon from '../assets/icons/calander.svg'

const date = new Date().toISOString().split('T')[0]
</script>

<template>
  <div class="flex justify-between items-center bg-gray-100 w-full h-16 shadow-md px-4 mx-4">
    <!-- Title -->
    <p class="text-2xl font-bold ml-5 text-black">Dash<span class="text-red-400">Board</span></p>

    <!-- Search -->
    <div class="flex">
      <input
        type="text"
        placeholder="Search"
        class="w-80 h-11 text-black bg-white shadow-md rounded-l-md px-3 border-none focus:outline-none"
      />
      <button class="bg-red-400 text-white h-11 px-4 rounded-r-md">
        <img :src="searchIcon" alt="Search Icon" />
      </button>
    </div>

    <!-- Notification & Calendar -->
    <div class="flex items-center gap-2">
      <button class="bg-red-400 text-white h-11 w-11 flex items-center justify-center rounded-md">
        <img :src="notificationIcon" alt="Notification" />
      </button>
      <button class="bg-red-400 text-white h-11 w-11 flex items-center justify-center rounded-md">
        <img :src="calanderIcon" alt="Calendar" />
      </button>
    </div>

    <!-- Date Display -->
    <div class="flex flex-col items-center">
      <p class="text-base text-black">Date</p>
      <p class="text-sm text-blue-400">{{ date }}</p>
    </div>
  </div>
</template>
