import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useErroHandling = defineStore('error', () => {
  const error = ref(false)

  function changeError(value: boolean) {
    error.value = value
  }

  return { error, changeError }
})
