import { atom } from 'recoil';

/**
 * アンケート選択肢のテキストフィールドの状態を管理するatom
 */
export const inputChoiceState = atom<string>({
  key: 'inputChoiceState',
  default: '',
});
