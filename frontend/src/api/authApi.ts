import { publicAxiosInstance } from '@/api/axiosInstance.ts'
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
  const response = await publicAxiosInstance.post('/register', userData)
  return response
}

export const loginUser = async (userData: UserLogin): Promise<AxiosResponse> => {
  const response = await publicAxiosInstance.post('/login', userData)
  return response
}
