import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useSideIndexStore = defineStore('index', () => {
  const count = ref(0)
  
  function increment(value : number) {
    count.value = value;}

  return { count,  increment }
})