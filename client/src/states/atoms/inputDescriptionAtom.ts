import { atom } from 'recoil';

/**
 * アンケート説明文のテキストフィールドの状態を管理するatom
 */
export const inputDescriptionState = atom<string>({
  key: 'inputDescriptionState',
  default: '',
});
