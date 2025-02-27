<script setup lang="ts">
import { defineProps, defineEmits, readonly } from 'vue'

const props = defineProps({
  placeHolder: String,
  iconPath: String,
  modelValue: String,
  isPassword: Boolean || false,
  readonly: Boolean || false,
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
    <v-icon :name="props.iconPath" fill="black" scale = '1.6' />
    <input
      :type="!props.isPassword ? 'text' : 'password'"
      :placeholder="props.placeHolder"
      :value="props.modelValue"
      @input="updateValue"
      class="w-full border-none bg-transparent text-black focus:outline-none"
      :readonly="props.readonly"
    />
  </div>
</template>
