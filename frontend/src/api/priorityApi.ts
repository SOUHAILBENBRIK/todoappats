import { type AxiosResponse } from 'axios'
import { privateAxiosInstance } from '@/api/axiosInstance.ts'

export interface PriorityCreation {
  name: string
  level: number
}

export const createPriority = async (priority: PriorityCreation): Promise<AxiosResponse> => {
  return await privateAxiosInstance.post('/priority', priority)
}

export const getPriority = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/priority')
}

export const getPriorityById = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get(`/priority/${id}`)
}
export const updatePriority = async (
  id: number,
  priority: PriorityCreation,
): Promise<AxiosResponse> => {
  return await privateAxiosInstance.put(`/priority/${id}`, priority)
}

export const deletePriority = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.delete(`/priority/${id}`)
}
