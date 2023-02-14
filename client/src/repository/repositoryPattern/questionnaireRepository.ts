import { StoreQuestionnaireProps } from "../../domain/useCaseProps/questionnaire/storeQuestionnaireProps";
import { $axios } from "../../utils/api";

const BASE_URL = process.env.API_BASE_URL;
const CLIENT_URL = process.env.NEXT_PUBLIC_API_CLIENT_URL;

export class QuestionnaireRepository {
  /**
   * アンケートランキング一覧取得APIを実行
   *
   * @param {String} type ランキング種別
   * @param {Number} page 取得ページ番号
   * @param {Number} limit 取得件数
   * @returns {Object}
   */
  async fetchRankingList(type: string, page: number, limit: number) {
    const response = await $axios.post(`${BASE_URL}questionnaires/ranking`, {
      type: type,
      page: page,
      limit: limit
    });
    return response;
  }

  /**
   * アンケート詳細APIを実行
   *
   * @param {number} questionnaireId 
   * @returns {Object}
   */
  async fetchQuestionnaire(questionnaireId: number) {
    const response = await $axios.get(`${BASE_URL}questionnaires/${questionnaireId}`);
    return response;
  }

  /**
   * アンケート登録APIを実行
   * @param {StoreQuestionnaireProps} questionnaire 
   * @returns {Object}
   */
  async save(questionnaire: StoreQuestionnaireProps) {
    const response = await $axios.post(`${CLIENT_URL}questionnaires`, questionnaire);
    return response;
  }
}
