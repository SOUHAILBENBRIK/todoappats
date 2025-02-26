import { privateAxiosInstance, publicAxiosInstance } from '@/api/axiosInstance.ts'
import type { AxiosResponse } from 'axios'

export interface UserRegistration {
  name: string
  userName: string
  lastName: string
  email: string
  password: string
  age: number
}
export interface UserLogin {
  email: string
  password: string
}

export const registerUser = async (userData: UserRegistration): Promise<AxiosResponse> => {
  return await publicAxiosInstance.post('/register', userData)
}

export const loginUser = async (userData: UserLogin): Promise<AxiosResponse> => {
  return await publicAxiosInstance.post('/login', userData)
}

