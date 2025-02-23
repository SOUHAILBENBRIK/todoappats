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
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
  },
})
</script>

<template>
  <div class="tasks-status">
    <div style="display: flex; flex-direction: row; gap: 20px; align-items: center">
      <img :src="completedTask" alt="icon" />
      <p>Task Status</p>
    </div>

    <div
      style="height: 70%; width: 100%; display: flex; justify-content: center; align-items: center"
    >
      <Pie :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<style scoped>
.tasks-status {
  background-color: #f5f5f5;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: start;
  gap: 20px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  height: 50%;
  padding: 10px 10px;
}
p {
  color: black;
}
</style>
