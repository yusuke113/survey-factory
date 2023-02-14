import { atom } from 'recoil';

/**
 * タグ名のテキストフィールドの状態を管理するatom
 */
export const inputTagState = atom<string>({
  key: 'inputTagState',
  default: '',
});
