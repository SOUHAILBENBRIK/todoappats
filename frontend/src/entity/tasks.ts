export interface Task {
    id : number ;
    title : string;
    description : string | null;
    createdAt: string;
    completedAt: string | null;
    deadline : string | null;
    completed : boolean ;
    userId : number | null;
}