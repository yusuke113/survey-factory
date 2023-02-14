import { selector } from "recoil";
import { inputChoiceState } from "../atoms/inputChoiceAtom";

/**
 * アンケート選択肢のテキストフィールドの文字数状態を管理するselector
 */
export const inputChoiceLengthState = selector<number>({
  key: 'inputChoiceLengthState',
  get: ({ get }) => {
    const inputChoice = get(inputChoiceState);
    return inputChoice.length;
  },
});
