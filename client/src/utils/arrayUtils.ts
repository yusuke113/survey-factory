// オブジェクトの配列の重複をチェックする
export const detectDuplicates = (array: object[]) => {
  // 重複をチェックするために、配列内のオブジェクトを文字列に変換する
  const stringArray = array.map(JSON.stringify);

  // Setを使用して重複を削除する
  const uniqueArray = new Set(stringArray);

  // 重複があった場合、配列のサイズが異なる
  if (stringArray.length !== uniqueArray.size) {
    return true;
  } else {
    return false;
  }
};
