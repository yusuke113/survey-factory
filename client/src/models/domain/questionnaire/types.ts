export type QuestionnaireRankingList = {
  questionnaires: Questionnaire[]
  pager: Pager
}

export interface Questionnaire {
  id: number
  title: string
  description: string
  thumbnailUrl: string
  createdAt: string
  voteCountAll: number
  user: User
}

export interface User {
  id: number
  name: string
}

export interface Pager {
  currentPage: number
  lastPage: number
  allCount: number
}
