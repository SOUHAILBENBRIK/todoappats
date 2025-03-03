<script setup>
import completedTaskIcon from '../assets/icons/TaskComplete.svg'
import { defineComponent, onMounted, ref } from 'vue'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'
import { Pie } from 'vue-chartjs'
import {getStatic} from '@/api/taksApi'

ChartJS.register(Title, Tooltip, Legend, ArcElement)
const completedTask = ref(0);
const paddingTask = ref(0);
const inProgressTask = ref(0);

// Chart Data
const chartData = ref({
  labels: ['Completed', 'In Progress', 'Pending'],
  datasets: [
    {
      data: [0, 0, 0], // Example data
      backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
      hoverBackgroundColor: ['#2A8BCB', '#E6B800', '#E65570'],
    },
  ],
})
function getStaticF(){
  getStatic().then((response) => {
    if (response.status === 200) {
      console.log(response.data.data)
      completedTask.value = response.data.data['completedTask']
      paddingTask.value = response.data.data['inProgressTask']
      inProgressTask.value = response.data.data['pendingTask']
      chartData.value = {
        labels: ['Completed', 'In Progress', 'Pending'],
        datasets: [
          {
            data: [response.data.data['completedTask'], response.data.data['inProgressTask'], response.data.data['pendingTask']],
            backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
            hoverBackgroundColor: ['#2A8BCB', '#E6B800', '#E65570'],
          },
        ],
      }
      console.log(chartData)
    } else {
      console.log('response', response)
    }
  }).catch((err) => {
    console.log('error', err.message)
  })
}

        

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
onMounted(() => {
  getStaticF()
})
</script>

<template>
  <div class="bg-gray-100 flex flex-col justify-center items-center gap-5 shadow-lg h-1/2 p-2.5">
    <div class="w-full flex flex-row gap-5 items-center justify-start">
      <img :src="completedTaskIcon" alt="icon" />
      <p class="text-black">Task Status</p>
    </div>

    <Pie :data="chartData" :options="chartOptions" :width="200" :height="200" />

    <div class="w-full flex flex-row gap-5 items-center justify-around">
      <p class="text-base text-black">Completed <span class="text-[#36A2EB]">  {{ completedTask}} %</span></p>
      <p class="text-base text-black">In Progress <span class="text-[#FFCE56]">  {{ paddingTask}} %</span></p>
      <p class="text-base text-black">Pending <span class="text-[#FF6384]">  {{inProgressTask}} %</span></p>
    </div>
  </div>
</template>
