import { atom } from 'recoil';
import { QreChoice } from '../../domain/models/qreChoice';

/**
 * アンケート作成画面で追加されたの選択肢リストの状態を管理するatom
 */
export const addChoiceListState = atom<Pick<QreChoice, 'body' | 'displayOrder'>[]>({
  key: 'addChoiceListState',
  default: [
    {
      body: '',
      displayOrder: 1,
    },
    {
      body: '',
      displayOrder: 2,
    },
  ],
});
