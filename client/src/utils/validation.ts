export const validation = () => {
  const targetList = [...document.querySelectorAll('.validate-text')];

  let message = {};

  // 空の入力欄チェック
  targetList.map((target) => {
    if (target.value.trim() === '') {
      message[target.getAttribute('name')] =`${target.dataset.validationName}を入力してください`;
      target.classList.add('error');
    }
  })

  return message;
}

export const removeError = (target) => {
  target.classList.remove('error');
}