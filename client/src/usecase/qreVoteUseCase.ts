import { QreVoteRepository } from "../repository/repositoryPattern/qreVoteRepository";

export class qreVoteUseCase {
  private qreVoteRepository: QreVoteRepository;

  /**
   * コンストラクタ
   */
  constructor() {
    this.qreVoteRepository = new QreVoteRepository;
  }

  /**
   * アンケート投票登録する
   * @param {Number} questionnaireId アンケートID
   * @param {Number} choiceId アンケート選択肢ID
   * @param {String} userToken ユーザートークン
   * @returns {Object}
   */
  async postQreVote(questionnaireId: number, choiceId: number, userToken: string) {
    return await this.qreVoteRepository.storeQreVote(questionnaireId, choiceId, userToken);
  }
}
