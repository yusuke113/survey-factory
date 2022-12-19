import { fetchRankingList, fetchHealth } from "../repository/repositoryPattern/questionnaireRepository";

export class QuestionnaireUseCase {

  async getRankingList(type, page, limit) {
    return await fetchRankingList(type, page, limit);
  }
  
  async getHealth(){
    return await fetchHealth();
  }

}
