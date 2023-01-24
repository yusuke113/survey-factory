import { $axios } from "../../utils/api";

const CLIENT_URL = process.env.NEXT_PUBLIC_API_CLIENT_URL;

export class QreVoteRepository {
  /**
   * アンケート投票登録APIを実行
   * @param {Number} questionnaireId アンケートID
   * @param {Number} choiceId アンケート選択肢ID
   * @param {String} userToken ユーザートークン
   * @returns {Object}
   */
  async storeQreVote(questionnaireId: number, choiceId: number, userToken: string) {

    const response = await $axios.post(`${CLIENT_URL}votes`,{
      questionnaireId: questionnaireId,
      choiceId: choiceId,
    });

    return response;
  }
}
