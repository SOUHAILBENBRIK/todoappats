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
}

export const createTask = async (task: TaskCreation): Promise<AxiosResponse> => {
  return await privateAxiosInstance.post('/tasks', task)
}
export const getTasks = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/tasks/user')
}
export const getTask = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get(`/tasks/${id}`)
}
export const updateTask = async (id: number, task: TaskCreation): Promise<AxiosResponse> => {
  return await privateAxiosInstance.put(`/tasks/${id}`, task)
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
export const updateTaskStatusPriority = async (
  id: number,
  status: number,
): Promise<AxiosResponse> => {
  return await privateAxiosInstance.put(`/tasks/${id}/status`, { status })
}
