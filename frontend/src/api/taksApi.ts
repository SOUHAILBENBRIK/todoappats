import type { AxiosResponse } from 'axios'
import { privateAxiosInstance } from '@/api/axiosInstance.ts'

export interface TaskCreation {
  title: string
  description: string | null
  createdAt: string
  completedAt: string | null
  deadline: string | null
  priority: number
  status: number
  user: number | null
  picture: string | null
}

export const createTask = async (task: FormData): Promise<AxiosResponse> => {
  return await privateAxiosInstance.post('/tasks', task, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}
export const getTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks')
}
export const getStatic = async () : Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/static')
}
export const getCompletedTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/completed')
}
export const getMissedTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/missed')
}
export const getTask = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get(`/tasks/${id}`)
}

export const updateTask = async (id: number, task: FormData): Promise<AxiosResponse> => {
  return await privateAxiosInstance.post(`/tasks/${id}`, task, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
}
export const deleteTask = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.delete(`/tasks/${id}`)
}
export const deleteAllTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.delete('/tasks/user')
}
export const getAllCompletedTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/completed/user')
}
export const getAllMissedTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/missed/user')
}
export const updateTaskStatus = async (
  id: number,
  status: number,
): Promise<AxiosResponse> => {
  return await privateAxiosInstance.patch(`/tasks/${id}`, { status })
}
