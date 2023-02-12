import { atom } from 'recoil';

/**
 * アンケートタイトルのテキストフィールドの状態を管理するatom
 */
export const inputTitleState = atom<string>({
  key: 'inputTitleState',
  default: '',
});
