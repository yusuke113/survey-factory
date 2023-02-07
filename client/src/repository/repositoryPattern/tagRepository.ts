import { $axios } from "../../utils/api";

const CLIENT_URL = process.env.NEXT_PUBLIC_API_CLIENT_URL;

export class TagRepository {
  /**
   * タグ登録APIを実行
   * @param {String} name タグ名
   * @returns {Object}
   */
  async storeTag(name: string) {

    const response = await $axios.post(`${CLIENT_URL}tags`,{
      name: name,
    });

    return response;
  }
}
