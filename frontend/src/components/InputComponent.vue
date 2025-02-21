<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

// Define the props with `modelValue` to allow v-model
// i can also use provide and inject but this should be more logical
const props = defineProps({
  placeHolder: String,
  iconPath: String,
  modelValue: String,
  isPassword: Boolean || false
})

// Define the emit function to handle the v-model update

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

// Emit the updated value
const updateValue = (event: Event) => {
  const input = event.target as HTMLInputElement
  emit('update:modelValue', input.value)
}
</script>

<template>
  <div class="input-container">
    <img :src="iconPath" class="icons" alt="icon" />
    <input
      :type="!isPassword ? 'text' : 'password'"
      :placeholder="placeHolder"
      :value="modelValue"
      @input="updateValue"
      class="input"
    />
  </div>
</template>

<style scoped>
.icons {
  height: 30px;
  width: 30px;
}
.input {
  border: none;
  width: 35vw;
  color: black;
  background-color: white;
}
.input:focus {
  outline: none;
  border: none;
}
.input-container {
  display: flex;
  align-items: center;
  border: 1px solid black;
  border-radius: 5px;
  padding: 10px 5px;
  justify-content: start;
  gap: 20px;
  width: 40vw;
}
</style>
