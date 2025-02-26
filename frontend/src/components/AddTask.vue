<script setup lang="ts">
import tasksIcon from '@/assets/icons/tasks.svg'
import { watch , ref } from 'vue'
const title = ref('')
const description = ref('')
const priority = ref(null)
const status = ref(null)
const deadline = ref(null);
const photo = ref(null);



</script>

<template>
    <div class="w-full h-full flex flex-col justify-start items-center gap-5">
        <InputComponent placeHolder="Enter task title" :iconPath="tasksIcon" v-model="title" />
        <InputComponent placeHolder="Enter task title" :iconPath="tasksIcon" v-model="title" />
        <InputComponent placeHolder="Enter task title" :iconPath="tasksIcon" v-model="title" />
        <InputComponent placeHolder="Enter task title" :iconPath="tasksIcon" v-model="title" />
        
    </div>

</template>