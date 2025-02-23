<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  placeHolder: String,
  iconPath: String,
  modelValue: String,
  isPassword: Boolean || false,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const updateValue = (event: Event) => {
  const input = event.target as HTMLInputElement
  emit('update:modelValue', input.value)
}
</script>

<template>
  <div class="flex items-center border border-gray-400 rounded-xl px-4 py-2 gap-4 w-full">
    <img :src="iconPath" class="h-6 w-6" alt="icon" />
    <input
      :type="!isPassword ? 'text' : 'password'"
      :placeholder="placeHolder"
      :value="modelValue"
      @input="updateValue"
      class="w-full border-none bg-transparent text-black focus:outline-none"
    />
  </div>
</template>
