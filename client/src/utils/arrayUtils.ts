// オブジェクトの配列の重複をチェックする
export const detectDuplicates = (array: object[]) => {
  // Set を使用して重複を削除し、元の配列との要素数を比較する
  return new Set(array.map(JSON.stringify)).size !== array.length;
};