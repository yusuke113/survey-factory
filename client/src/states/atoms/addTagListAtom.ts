import { atom } from 'recoil';
import { Tag } from '../../domain/models/tag';

/**
 * アンケート作成画面で追加されたのタグリストの状態を管理するatom
 */
export const addTagListState = atom<Tag[]>({
  key: 'addTagListState',
  default: [],
});
