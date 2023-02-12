import { selector } from "recoil";
import { inputDescriptionState } from "../atoms/inputDescriptionAtom";

/**
 * アンケート説明文のテキストフィールドの文字数状態を管理するselector
 */
export const inputDescriptionLengthState = selector<number>({
  key: 'inputDescriptionLengthSelectorState',
  get: ({ get }) => {
    const inputDescription = get(inputDescriptionState);
    return inputDescription.length;
  },
});
