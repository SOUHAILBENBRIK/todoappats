<script setup>
import completedTask from '../assets/icons/TaskComplete.svg'
import { defineComponent, ref } from 'vue'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'
import { Pie } from 'vue-chartjs'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

// Chart Data
const chartData = ref({
  labels: ['Completed', 'In Progress', 'Pending'],
  datasets: [
    {
      data: [40, 35, 25], // Example data
      backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
      hoverBackgroundColor: ['#2A8BCB', '#E6B800', '#E65570'],
    },
  ],
})

// Chart Options
const chartOptions = ref({
  responsive: false,
  plugins: {
    title: {
      display: false,
      text: 'Tasks Status',
    },
    legend: {
      display: false,
    },
  },
})
</script>

<template>
  <div class="bg-gray-100 flex flex-col justify-center items-center gap-5 shadow-lg h-1/2 p-2.5">
    <div class="w-full flex flex-row gap-5 items-center justify-start">
      <img :src="completedTask" alt="icon" />
      <p class="text-black">Task Status</p>
    </div>

    <Pie :data="chartData" :options="chartOptions" :width="200" :height="200" />

    <div class="w-full flex flex-row gap-5 items-center justify-around">
      <p class="text-base text-black">Completed <span class="text-[#36A2EB]"> 40%</span></p>
      <p class="text-base text-black">In Progress<span class="text-[#FFCE56]"> 35%</span></p>
      <p class="text-base text-black">Pending <span class="text-[#FF6384]"> 25%</span></p>
    </div>
  </div>
</template>
