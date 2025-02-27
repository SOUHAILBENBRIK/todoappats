import type { AxiosResponse } from 'axios'
import { privateAxiosInstance } from './axiosInstance'

export const getUser = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/me')
}

export const updateUser = async (data: any): Promise<AxiosResponse> => {
  return await privateAxiosInstance.put('/user', data)
}


export const deleteUser = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.delete('/user')
}
