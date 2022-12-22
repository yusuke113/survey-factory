import { User } from "./User"

export interface Questionnaire {
  id: number
  title: string
  description: string
  thumbnailUrl: string
  createdAt: string
  voteCountAll: number
  user: User
}