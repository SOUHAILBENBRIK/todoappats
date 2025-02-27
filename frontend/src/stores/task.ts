import { defineStore } from "pinia"
import { ref } from "vue"

export const useTaskHandling = defineStore('error', () => {
  const isNewTask = ref(false)
  const isEditTask = ref(false)

  function changeNewTask(value: boolean) {
    isNewTask.value = value
  }
  function changeEditTask(value: boolean) {
    isEditTask.value = value
  }

  return { isEditTask, isNewTask , changeEditTask , changeNewTask }
})
