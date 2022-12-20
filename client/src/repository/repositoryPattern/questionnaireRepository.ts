import { $axios } from "../../utils/api";

const BASE_URL = process.env.API_BASE_URL;

export class QuestionnaireRepository {
  /**
   * アンケートランキング一覧取得APIを実行
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
}
