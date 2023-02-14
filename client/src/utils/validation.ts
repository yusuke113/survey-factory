export const validation = (): { [key: string]: string } => {

  let errorMessage: { [key: string]: string } = {};

  const targetList = [...document.querySelectorAll('.validate-text')] as HTMLInputElement[];

  // 空の入力欄チェック
  targetList.map((target) => {
    if (target.value.trim() === '') {
      errorMessage[target.getAttribute('name') as string] = `${target.dataset.validationName}を入力してください`;
      target.classList.add('error');
    }
  })

  return errorMessage;
}

export const removeError = (target: HTMLElement) => {
  target.classList.remove('error');
}
