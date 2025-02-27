import type { Priority } from './priority'
import type { Status } from './status'

export interface Task {
  id: number
  title: string
  description: string | null
  createdAt: string
  completedAt: string | null
  deadline: string | null
  priority: Priority
  status: Status
  picture: string | null
  user: number | null
}
