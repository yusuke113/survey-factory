import { QuestionnaireRepository } from "../repository/repositoryPattern/questionnaireRepository";

export class QuestionnaireUseCase {
  private questionnaireRepository: QuestionnaireRepository;

  /**
   * コンストラクタ
   */
  constructor() {
    this.questionnaireRepository = new QuestionnaireRepository;
  }

  /**
   * アンケートのランキング一覧を取得する
   * @param {String} type ランキング種別
   * @param {Number} page 取得ページ番号
   * @param {Number} limit 取得件数
   * @returns {Object}
   */
  getRankingList(type: string, page: number, limit: number) {
    return this.questionnaireRepository.fetchRankingList(type, page, limit);
  }

  /**
   * 
   * @param {number} questionnaireId 
   * @returns {Object}
   */
  getQuestionnaire(questionnaireId: number) {
    return this.questionnaireRepository.fetchQuestionnaire(questionnaireId);
  }
}
