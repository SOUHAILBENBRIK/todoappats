import type { AxiosResponse } from "axios";
import  { privateAxiosInstance } from "@/api/axiosInstance.ts";

export interface TaskCreation {
    title : string;
    description : string | null;
    createdAt: string;
    completedAt: string | null;
    deadline : string | null;
    priority : number;
    status : number;
    user : number | null;
}



export const createTask = async ( task : TaskCreation) : Promise<AxiosResponse> => {
    return  await privateAxiosInstance.get('/tasks', task);
    

}