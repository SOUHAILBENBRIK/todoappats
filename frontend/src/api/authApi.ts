import {publicAxiosInstance} from '@/api/axiosInstance.ts'
import type { AxiosResponse } from 'axios';


export interface  UserRegistration {
  name : string ,
  userName : string ,
  lastName: string ,
  email : string,
  password : string ,
  age : number
}
export interface UserLogin {
  email : string ,
  password : string
}


export const registerUser = async (userData: UserRegistration): Promise<AxiosResponse> => {
  try {
    const response = await publicAxiosInstance.post('/register', userData);
    return response;
  } catch (error : unknown) {
    throw new Error('Error registering user'+error);
  }
};

export const loginUser = async (userData: UserLogin): Promise<AxiosResponse> => {
  try {
    const response = await publicAxiosInstance.post('/login', userData);
    return response;
  } catch (error : unknown) {
    throw new Error('Error in user login'+error);
  }
};
