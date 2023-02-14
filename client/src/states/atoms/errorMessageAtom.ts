import { atom } from 'recoil';

interface errorMessageProps {
  [key: string]: string
}

/**
 * エラーメッセージを管理するatom
 */
export const errorMessageState = atom<errorMessageProps>({
  key: 'errorMessageState',
  default: {}
});
