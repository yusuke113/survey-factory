import { TagRepository } from "../repository/repositoryPattern/tagRepository";

export class TagUseCase {
  private tagRepository: TagRepository;

  /**
   * コンストラクタ
   */
  constructor() {
    this.tagRepository = new TagRepository;
  }

  /**
   * タグ名が既に存在していればそのタグ情報をDBから取得、
   * 存在しない場合、タグ登録をする
   *
   * @param {String} name タグ名
   * @returns {Object}
   */
  async postTag(name: string) {
    return await this.tagRepository.storeTag(name);
  }
}
