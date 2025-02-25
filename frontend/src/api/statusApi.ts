import { type AxiosResponse } from 'axios'
import { privateAxiosInstance } from '@/api/axiosInstance.ts'
import type { Status } from '@/entity/status'
export interface StatusCreation {
  name: string
}

export const createStatus = async (status: StatusCreation): Promise<AxiosResponse> => {
  return await privateAxiosInstance.post('/status', status)
}

export const getStatus = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/status')
}

export const getStatusById = async (id: number): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get(`/status/${id}`)
}

export const updateStatus = async (id: number, status: Status): Promise<AxiosResponse> => {
  return await privateAxiosInstance.put(`/status/${id}`, status)
}
