export interface Task {
  id: number
  title: string
  description: string | null
  createdAt: string
  completedAt: string | null
  deadline: string | null
  priority: number
  status: number
  picture: string | null
  user: number | null
}
