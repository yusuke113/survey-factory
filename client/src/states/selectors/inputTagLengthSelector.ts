import { selector } from "recoil";
import { inputTagState } from "../atoms/inputTagAtom";

/**
 * タグ名のテキストフィールドの文字数状態を管理するselector
 */
export const inputTagLengthState = selector<number>({
  key: 'inputTagLengthState',
  get: ({ get }) => {
    const inputTag = get(inputTagState);
    return inputTag.length;
  },
});