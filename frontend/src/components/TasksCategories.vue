<script setup lang="ts">
import iconAdd from '@/assets/icons/add.svg'
import iconBlock from '@/assets/icons/block.svg'
import type { Priority } from '@/entity/priority'
import { type Status } from '@/entity/status'
import { useRouter } from 'vue-router'
import { onMounted, ref, provide, watch } from 'vue'
import { getStatus, deleteStatus } from '@/api/statusApi'
import { getPriority, deletePriority } from '@/api/priorityApi'
import AddPriority from './AddPriority.vue'
import AddStatus from './AddStatus.vue'
import ModifyPriority from './ModifyPriority.vue'
import ModifyStatus from './ModifyStatus.vue'
import Loading from './Loading.vue'
const router = useRouter()
const status = ref<Status[]>([])
const priority = ref<Priority[]>([])
const isNewPriority = ref(false)
const isNewStatus = ref(false)
const isEditPriority = ref(false)
const loading = ref(true)
const isEditStatus = ref(false)
const currentPriority = ref<Priority | null>(null)
const currentStatus = ref<Status | null>(null)
provide('isNewStatus', isNewStatus)
provide('isNewPriority', isNewPriority)
provide('isEditPriority', isEditPriority)
provide('isEditStatus', isEditStatus)

function deleteStatusF(status: Status) {
  loading.value = true
  deleteStatus(status.id)
    .then((response) => {
      if (response.status === 200) {
        loading.value = false
        getAllStatus()
      } else {
        console.log('response', response)
        loading.value = false
      }
    })
    .catch((err) => {
      console.log('error', err)
      loading.value = false
    })
}
function deletePriorityF(priority: Priority) {
  loading.value = true
  deletePriority(priority.id)
    .then((response) => {
      console.log(response)
      if (response.status === 200) {
        loading.value = false
        getAllPriority()
      } else {
        console.log('response', response)
        loading.value = false
      }
    })
    .catch((err) => {
      console.log('error', err.message)
      loading.value = false
    })
}

async function getAllStatus() {
  try {
    const response = await getStatus()
    status.value = JSON.parse(response.data.data)
  } catch (err) {
    console.log('error', err)
  }
}
async function getAllPriority() {
  try {
    const response = await getPriority()
    priority.value = JSON.parse(response.data.data)
  } catch (err) {
    console.log('error', err)
  }
}
function addPriority() {
  isNewPriority.value = true
}
function addStatus() {
  isNewStatus.value = true
}
function editStatus(status: Status) {
  isEditStatus.value = true
  currentStatus.value = status
}
function editPriority(priority: Priority) {
  isEditPriority.value = true
  currentPriority.value = priority
}
watch(isNewPriority, (newIsNewPriority) => {
  if (!newIsNewPriority) {
    getAllPriority()
  }
})
watch(isNewStatus, (newIsNewStatus) => {
  if (!newIsNewStatus) {
    getAllStatus()
  }
})
watch(isEditPriority, (newIsEditPriority) => {
  if (!newIsEditPriority) {
    getAllPriority()
  }
})
watch(isEditStatus, (newIsEditStatus) => {
  if (!newIsEditStatus) {
    getAllStatus()
  }
})

onMounted(async () => {
  await getAllPriority()
  await getAllStatus()
  loading.value = false
})
</script>

<template>
  <AddPriority v-if="isNewPriority" />
  <AddStatus v-else-if="isNewStatus" />
  <ModifyPriority v-else-if="isEditPriority" :priority="currentPriority!" />
  <ModifyStatus v-else-if="isEditStatus" :status="currentStatus!" />
  <Loading v-else-if="loading" />
  <div
    class="w-[87vw] h-[90vh] flex flex-col items-start justify-start border border-black rounded-2xl px-10"
    v-else
  >
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-8">
      <p class="text-amber-400 text-2xl">Task Categories</p>
      <p class="text-black underline cursor-pointer" @click="router.push('/')">Go Back</p>
    </div>
    <div class="w-full py-10">
      <div class="w-full flex flex-row items-center justify-between">
        <p class="text-black">Task Status</p>
        <div
          class="flex flex-row items-center justify-between gap-5 cursor-pointer"
          @click="addStatus"
        >
          <img :src="iconAdd" alt="icon add" class="h-5 w-5" />
          <p class="text-black">Add Status</p>
        </div>
      </div>
      <div class="overflow-x-auto py-2">
        <table class="min-w-full border border-gray-300 shadow-lg overflow-hidden">
          <thead>
            <tr class="bg-gray-300 rounded-t-lg">
              <th class="text-black px-4 py-2 border-r border-gray-400">Id</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Task Status</th>
              <th class="text-black px-4 py-2 border-gray-400">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in status"
              :key="item.id"
              class="text-black text-center px-4 py-2 bg-gray-100"
            >
              <td class="text-black border-r border-gray-400">{{ item.id }}</td>
              <td class="text-black border-r border-gray-400">{{ item.name }}</td>
              <td class="py-1 flex gap-2 items-center justify-center" v-if="item.user != null">
                <button
                  class="bg-red-400 text-white w-16 py-1 rounded-md mx-5"
                  @click="editStatus(item)"
                >
                  Edit
                </button>
                <button
                  class="bg-red-400 text-white w-16 py-1 rounded-md"
                  @click="deleteStatusF(item)"
                >
                  Delete
                </button>
              </td>
              <td class="flex items-center justify-center py-2" v-else>
                <img :src="iconBlock" alt="block icon" class="h-5 w-5" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="w-full py-10">
      <div class="w-full flex flex-row items-center justify-between">
        <p class="text-black">Task Priority</p>
        <div
          class="flex flex-row items-center justify-between gap-5 cursor-pointer"
          @click="addPriority"
        >
          <img :src="iconAdd" alt="icon add" class="h-5 w-5" />
          <p class="text-black">Add Priority</p>
        </div>
      </div>
      <div class="overflow-x-auto py-2">
        <table class="min-w-full border border-gray-300 shadow-lg overflow-hidden">
          <thead>
            <tr class="bg-gray-300 rounded-t-lg">
              <th class="text-black px-4 py-2 border-r border-gray-400">Id</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Task Priority</th>
              <th class="text-black px-4 py-2 border-r border-gray-400">Priority Level</th>
              <th class="text-black px-4 py-2 border-gray-400">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in priority"
              :key="item.id"
              class="text-black text-center px-4 py-2 bg-gray-100"
            >
              <td class="text-black border-r border-gray-400">{{ item.id }}</td>
              <td class="text-black border-r border-gray-400">{{ item.name }}</td>
              <td class="text-black border-r border-gray-400">{{ item.level }}</td>
              <td class="py-1 flex gap-2 items-center justify-center" v-if="item.user != null">
                <button
                  class="bg-red-400 text-white w-16 py-1 rounded-md mx-5"
                  @click="editPriority(item)"
                >
                  Edit
                </button>
                <button
                  class="bg-red-400 text-white w-16 py-1 rounded-md"
                  @click="deletePriorityF(item)"
                >
                  Delete
                </button>
              </td>
              <td class="flex items-center justify-center py-2" v-else>
                <img :src="iconBlock" alt="block icon" class="h-5 w-5" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
