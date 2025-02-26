import type { AxiosResponse } from 'axios'
import { privateAxiosInstance } from './axiosInstance'

export const getUser = async (): Promise<AxiosResponse> => {
  return await privateAxiosInstance.get('/me')
}
