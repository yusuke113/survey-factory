import { selector } from "recoil";
import { addTagListState } from "../atoms/addTagListAtom";

/**
 * アンケート作成画面で追加されたのタグリストの数を状態を管理するselector
 */
export const addTagListLengthState = selector<number>({
  key: 'addTagListLengthState',
  get: ({ get }) => {
    const addTagList = get(addTagListState);
    return addTagList.length;
  },
});
