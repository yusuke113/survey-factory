import { selector } from "recoil";
import { inputTitleState } from "../atoms/inputTitleAtom";

/**
 * アンケートタイトルのテキストフィールドの文字数状態を管理するselector
 */
export const inputTitleLengthState = selector<number>({
  key: 'inputTitleLengthState',
  get: ({ get }) => {
    const inputTitle = get(inputTitleState);
    return inputTitle.length;
  },
});
